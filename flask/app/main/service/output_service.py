import uuid
import datetime

from flask_sqlalchemy import SQLAlchemy
from app.main import db
from app.main.model.output import Output


def get_product_cost(params):
    # SELECT `product/ProductName` as product, sum(`lineitem/UnblendedCost`) as cost FROM `output_mod`
    # WHERE `lineItem/UsageAccountId` = 2147483647
    # GROUP BY `product/ProductName` LIMIT 10 OFFSET  0

    data = []

    page = params.get('page', 1)
    limit = params.get('limit', 10)
    offset = (page - 1) * limit
    UsageAccountId = params.get('UsageAccountId', None)

    if UsageAccountId:
        where = []
        if UsageAccountId:
            where.append("`lineItem/UsageAccountId` = %s" % (UsageAccountId))

        engine = db.get_engine()
        sql = 'SELECT `product/ProductName` as ProductName, sum(`lineitem/UnblendedCost`) as Cost FROM `output_mod`'
        for k, v in enumerate(where):
            sql += ' WHERE %s' % v if k == 0 else ' AND %s' % v
        sql += ' GROUP BY `product/ProductName` LIMIT %s OFFSET %s' % (limit, offset)
        rs = engine.execute(sql)

        for row in rs:
            data.append({'ProductName': row['ProductName'], 'Cost': row['Cost']})

    return data


def get_product_usage_amount(params):
    # SELECT DISTINCT `product/ProductName` as product FROM `output_mod`
    # WHERE `lineItem/UsageAccountId` = 2147483647 AND `product/ProductName`
    # like '%Amazon%' LIMIT 4 OFFSET  0

    data = []

    page = params.get('page', 1)
    limit = params.get('limit', 10)
    offset = (page - 1) * limit
    UsageAccountId = params.get('UsageAccountId', None)
    begin_date = params.get('begin_date', None)
    end_date = params.get('end_date', None)

    if UsageAccountId:
        engine = db.get_engine()
        sql = 'SELECT DISTINCT `product/ProductName` as ProductName FROM `output_mod`'
        sql += ' WHERE `lineItem/UsageAccountId` = %s' % (UsageAccountId)
        sql += ' GROUP BY `product/ProductName` LIMIT %s OFFSET %s' % (limit, offset)
        products = engine.execute(sql)
        if products:
            for product in products:
                where = [
                    "`lineItem/UsageAccountId` = %s" % (UsageAccountId),
                    "`product/ProductName` = '%s'" % (product['ProductName'])
                ]
                if begin_date:
                    where.append("`lineItem/UsageStartDate` >= '%s 00:00:00'" % (begin_date))
                if end_date:
                    where.append("`lineItem/UsageEndDate` <= '%s 23:59:59'" % (end_date))

                sql = "SELECT DATE_FORMAT(`lineItem/UsageStartDate`, '%%Y-%%m-%%d') as days, sum(`lineItem/UsageAmount`) as amount FROM `output_mod`";
                for k, v in enumerate(where):
                    sql += ' WHERE %s' % v if k == 0 else ' AND %s' % v
                sql += ' GROUP BY `product/ProductName`, days ORDER BY days ASC'
                record = engine.execute(sql)

                record_list = []
                for row in record:
                    record_list.append({
                        'date': row['days'],
                        'amount': row['amount'],
                    })

                if record_list:
                    data.append({
                        'ProductName': product['ProductName'],
                        'RecordList': record_list
                    })

    return data
