## API Documentation
    1. Get __lineItem/UnblendedCost__ grouping by __product/productname__
        URL: http://localhost/ecloudvalley/api/product_cost.php
        - Input
          | Column | Required | type | default |
          | ------ | -------- | ---- | -------:|
          | lineitem/usageaccountid | true | integer |  |
          | limit |  | integer | 10 |
          | page |  | integer | 1 |
          | q |  | string |  |
        - Output
        ```JSON
            {
                "status": true,
                "message": "",
                "data": {
                    "AWS Premium Support": "4569.04",
                    "Amazon Elastic Compute Cloud": "110149.20095045527",
                    "AWS Data Transfer": "10.659999999999998",
                    "Amazon Simple Storage Service": "3859.442267241301",
                    "AmazonCloudWatch": "2249.30054493629",
                    "Amazon Virtual Private Cloud": "2812.2435629171428",
                    "Amazon GuardDuty": "502.75402283010004",
                    "AWS Key Management Service": "26.391743759197343",
                    "Amazon Relational Database Service": "54326.55715509834",
                    "AWS Config": "170.79599999999903"
                }
            }
        ```
    2. Get daily __lineItem/UsageAmount__ grouping by __product/productname__
        URL：http://localhost/ecloudvalley/api/product_usage_amount.php
        - Input
          | Column | Required | type | default |
          | ------ | -------- | ---- | -------:|
          | lineitem/usageaccountid | true | integer |  |
          | limit |  | integer | 10 |
          | page |  | integer | 1 |
          | q |  | string |  |
          | begin_date |  | string(YYYY-MM-DD) |  |
          | end_date |  | string(YYYY-MM-DD) |  |
        - Output
        ```JSON
            {
                "status": true,
                "message": "",
                "data": {
                    "Amazon Elastic Compute Cloud": {
                        "2020-04-01": "36510127.48728126",
                        "2020-04-02": "36195143.80460417",
                        "2020-04-03": "39012142.406336255",
                        "2020-04-04": "48872446.8230668",
                        "2020-04-05": "1540.0890970903029"
                    },
                    "Amazon Simple Storage Service": {
                        "2020-04-01": "7874025.050043392",
                        "2020-04-02": "7839640.322548867",
                        "2020-04-03": "7358265.419974347",
                        "2020-04-04": "14760224.306919785",
                        "2020-04-05": "19312857.32232986"
                    },
                    "AmazonCloudWatch": {
                        "2020-04-01": "1375949.7953812245",
                        "2020-04-02": "1363630.7068387123",
                        "2020-04-03": "1321291.918775467",
                        "2020-04-04": "1249540.8701098387",
                        "2020-04-05": "1191.088394266199"
                    },
                    "Amazon Virtual Private Cloud": {
                        "2020-04-01": "2071.867959791397",
                        "2020-04-02": "2058.1612552619995",
                        "2020-04-03": "2048.110935685197",
                        "2020-04-04": "2052.5480928530965",
                        "2020-04-05": "0.00023983329999999935"
                    }
                }
            }
        ```

## DB schema

    ```SQL
        CREATE TABLE `output_mod` (
        `f1` varchar(255) DEFAULT NULL,
        `identity/LineItemId` varchar(255) DEFAULT NULL,
        `bill/InvoiceId` varchar(255) DEFAULT NULL,
        `bill/BillingEntity` varchar(255) DEFAULT NULL,
        `bill/BillType` varchar(255) DEFAULT NULL,
        `bill/PayerAccountId` varchar(255) DEFAULT NULL,
        `bill/BillingPeriodStartDate` varchar(255) DEFAULT NULL,
        `lineItem/UsageAccountId` int(11) NOT NULL,
        `lineItem/LineItemType` varchar(255) DEFAULT NULL,
        `lineItem/UsageStartDate` datetime DEFAULT NULL,
        `lineItem/UsageEndDate` datetime DEFAULT NULL,
        `lineItem/UsageType` varchar(255) DEFAULT NULL,
        `lineItem/Operation` varchar(255) DEFAULT NULL,
        `lineItem/AvailabilityZone` varchar(255) DEFAULT NULL,
        `lineItem/ResourceId` varchar(255) DEFAULT NULL,
        `lineItem/UsageAmount` double NOT NULL,
        `lineItem/NormalizationFactor` varchar(255) DEFAULT NULL,
        `lineItem/NormalizedUsageAmount` varchar(255) DEFAULT NULL,
        `lineItem/UnblendedRate` varchar(255) DEFAULT NULL,
        `lineItem/UnblendedCost` double NOT NULL,
        `lineItem/LineItemDescription` varchar(255) DEFAULT NULL,
        `product/ProductName` varchar(255) DEFAULT NULL,
        `product/cacheEngine` varchar(255) DEFAULT NULL,
        `product/databaseEdition` varchar(255) DEFAULT NULL,
        `product/databaseEngine` varchar(255) DEFAULT NULL,
        `product/deploymentOption` varchar(255) DEFAULT NULL,
        `product/instanceType` varchar(255) DEFAULT NULL,
        `product/instanceTypeFamily` varchar(255) DEFAULT NULL,
        `product/licenseModel` varchar(255) DEFAULT NULL,
        `product/location` varchar(255) DEFAULT NULL,
        `product/operatingSystem` varchar(255) DEFAULT NULL,
        `product/region` varchar(255) DEFAULT NULL,
        `product/tenancy` varchar(255) DEFAULT NULL,
        `pricing/LeaseContractLength` varchar(255) DEFAULT NULL,
        `pricing/OfferingClass` varchar(255) DEFAULT NULL,
        `pricing/PurchaseOption` varchar(255) DEFAULT NULL,
        `pricing/publicOnDemandRate` varchar(255) DEFAULT NULL,
        `pricing/term` varchar(255) DEFAULT NULL,
        `reservation/AmortizedUpfrontCostForUsage` varchar(255) DEFAULT NULL,
        `reservation/AmortizedUpfrontFeeForBillingPeriod` varchar(255) DEFAULT NULL,
        `reservation/EffectiveCost` varchar(255) DEFAULT NULL,
        `reservation/EndTime` varchar(255) DEFAULT NULL,
        `reservation/ModificationStatus` varchar(255) DEFAULT NULL,
        `reservation/NumberOfReservations` varchar(255) DEFAULT NULL,
        `reservation/RecurringFeeForUsage` varchar(255) DEFAULT NULL,
        `reservation/ReservationARN` varchar(255) DEFAULT NULL,
        `reservation/StartTime` varchar(255) DEFAULT NULL,
        `reservation/SubscriptionId` varchar(255) DEFAULT NULL,
        `reservation/TotalReservedUnits` varchar(255) DEFAULT NULL,
        `reservation/UnusedAmortizedUpfrontFeeForBillingPeriod` varchar(255) DEFAULT NULL,
        `reservation/UnusedNormalizedUnitQuantity` varchar(255) DEFAULT NULL,
        `reservation/UnusedQuantity` varchar(255) DEFAULT NULL,
        `reservation/UnusedRecurringFee` varchar(255) DEFAULT NULL,
        `reservation/UpfrontValue` varchar(255) DEFAULT NULL,
        `savingsPlan/TotalCommitmentToDate` varchar(255) DEFAULT NULL,
        `savingsPlan/SavingsPlanARN` varchar(255) DEFAULT NULL,
        `savingsPlan/SavingsPlanRate` varchar(255) DEFAULT NULL,
        `savingsPlan/UsedCommitment` varchar(255) DEFAULT NULL,
        `savingsPlan/SavingsPlanEffectiveCost` varchar(255) DEFAULT NULL,
        `savingsPlan/AmortizedUpfrontCommitmentForBillingPeriod` varchar(255) DEFAULT NULL,
        `savingsPlan/RecurringCommitmentForBillingPeriod` varchar(255) DEFAULT NULL,
        `savingsPlan/PurchaseTerm` varchar(255) DEFAULT NULL,
        `savingsPlan/PaymentOption` varchar(255) DEFAULT NULL,
        `savingsPlan/OfferingType` varchar(255) DEFAULT NULL,
        `savingsPlan/Region` varchar(255) DEFAULT NULL,
        `savingsPlan/StartTime` varchar(255) DEFAULT NULL,
        `savingsPlan/EndTime` varchar(255) DEFAULT NULL,
        `resourceTags/aws:createdBy` varchar(255) DEFAULT NULL,
        `resourceTags/user:Billing` varchar(255) DEFAULT NULL,
        `resourceTags/user:EBS` varchar(255) DEFAULT NULL,
        `resourceTags/user:EC2` varchar(255) DEFAULT NULL,
        `resourceTags/user:Environment` varchar(255) DEFAULT NULL,
        `resourceTags/user:Name` varchar(255) DEFAULT NULL,
        `resourceTags/user:Project` varchar(255) DEFAULT NULL,
        `resourceTags/user:RDS` varchar(255) DEFAULT NULL,
        `resourceTags/user:Site` varchar(255) DEFAULT NULL,
        `resourceTags/user:autotag` varchar(255) DEFAULT NULL,
        `resourceTags/user:ext01` varchar(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ALTER TABLE `output_mod`
        ADD KEY `UsageAccountId` (`lineItem/UsageAccountId`),
        ADD KEY `ProductName` (`product/ProductName`),
        ADD KEY `UsageDT` (`lineItem/UsageStartDate`,`lineItem/UsageEndDate`);
        COMMIT;
    ```
