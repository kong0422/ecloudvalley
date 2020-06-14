from datetime import datetime

from flask_restplus import Namespace, fields

class DTFormat(fields.Raw):
    def format(self, value):
        return value[:10]


class UserDto:
    api = Namespace('user', description='user related operations')
    user = api.model('user', {
        'email': fields.String(required=True),
        'username': fields.String(required=True),
        'password': fields.String(required=True),
        'public_id': fields.String(description='user Identifier')
    })


class AuthDto:
    api = Namespace('auth', description='authentication related operations')
    user_auth = api.model('auth_details', {
        'email': fields.String(required=True, description='The email address'),
        'password': fields.String(required=True, description='The user password '),
    })


class ProductDto:
    api = Namespace('product')
    cost = api.model('product_cost', {
        'ProductName': fields.String(required=True),
        'Cost': fields.Float(required=True),
    })

    usage_amount_record = api.model('product_usage_amount_record', {
        'date': DTFormat(),
        'amount': fields.Float(required=True),
    })

    usage_amount = api.model('product_usage_amount', {
        'ProductName': fields.String(required=True),
        'RecordList': fields.Nested(usage_amount_record, default=[]),
    })
