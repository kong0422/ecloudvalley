<?php
/**
 * Get lineItem/UnblendedCost grouping by product/productname
 * Input
 * Column	Required
 * lineitem/usageaccountid	true
 * Output
 * {
 *  "{product/productname_A}": "sum(lineitem/unblendedcost)",
 *  "{product/productname_B}": "sum(lineitem/unblendedcost)",
 *  ...
 * }
 */

set_time_limit(0);
include('../dbconn.php');
include('../function.php');

$method = get($_SERVER, 'REQUEST_METHOD');
if ($method) strtoupper($method);
switch ($method) {

    case 'GET':
        $response = [
            'status' => FALSE,
            'message' => '',
            'data' => [],
        ];

        $page = get($_GET, 'page', 1);
        $limit = get($_GET, 'limit', 10);
        $offset = ($page - 1) * $limit;
        $q = get($_GET, 'q');
        $UsageAccountId = get($_GET, 'UsageAccountId');

        if (!$UsageAccountId) {
            $response['message'] = '[UsageAccountId] is a required property';
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit;
        }

        $conditions = [];
        if ($UsageAccountId) $conditions[] = "`lineItem/UsageAccountId` = {$UsageAccountId}";
        if ($q) $conditions[] = "`product/ProductName` like '%{$q}%'";

        $sql = "SELECT `product/ProductName` as product, sum(`lineitem/UnblendedCost`) as cost FROM `output_mod`";
        foreach ($conditions as $k => $c) {
            if ($k == 0) {
                $sql.= " WHERE {$c}";
            } else {
                $sql.= " AND {$c}";
            }
        }
        $sql.= " GROUP BY `product/ProductName` LIMIT {$limit} OFFSET  $offset";
        if ($result = $mysqli->query($sql)) {
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $response['data'][$row['product']] = $row['cost'];
            }
            $result->free();
        }

        $response['status'] = TRUE;

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "The page that you have requested could not be found.";

}

$mysqli->close();
exit;
?>
