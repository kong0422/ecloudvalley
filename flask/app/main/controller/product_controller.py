from flask import request
from flask_restplus import Resource

from app.main.util.decorator import admin_token_required
from ..util.dto import ProductDto
from ..service.output_service import get_product_cost, get_product_usage_amount

api = ProductDto.api


@api.route('/cost')
class ProductCost(Resource):
    @admin_token_required
    @api.marshal_list_with(ProductDto.cost)
    def get(self):
        """List product cost"""
        data = request.args
        return get_product_cost(data)


@api.route('/usage_amount')
class ProductUsageAmount(Resource):
    @admin_token_required
    @api.marshal_list_with(ProductDto.usage_amount)
    def get(self):
        """List product usage amounts"""
        data = request.args
        return get_product_usage_amount(data)
