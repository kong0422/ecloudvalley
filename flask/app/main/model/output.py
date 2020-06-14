
from .. import db, flask_bcrypt
import datetime
from app.main.model.blacklist import BlacklistToken
from ..config import key
import jwt


class Output(db.Model):
    """ Test data """
    __tablename__ = "output_mod"

    f1 = db.Column(db.Integer, primary_key=True, autoincrement=True)
    UsageAccountId = db.Column('lineItem/UsageAccountId', db.Integer)
    UnblendedCost = db.Column('lineItem/UnblendedCost', db.Float)
    UsageStartDate = db.Column('lineItem/UsageStartDate', db.DateTime)
    UsageEndDate = db.Column('lineItem/UsageEndDate', db.DateTime)
    ProductName = db.Column('product/ProductName', db.String(100))

    def __repr__(self):
        return "<output_mod '{}'>".format(self.id)
