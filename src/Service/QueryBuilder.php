<?php
/**
 * Created by PhpStorm.
 * User: coderaf
 */

namespace GenesisGlobal\Salesforce\SalesforceBundle\Service;


/**
 * Class QueryBuilder
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Service
 */
class QueryBuilder implements QueryBuilderInterface
{
    const CONDITION_OPERATORS = [
        '=', '>', '<','LIKE', 'IN'
    ];

    /**
     * @param $fields
     * @param $from
     * @param null $conditions
     * @return string
     */
    public function build($fields, $from, $conditions = null)
    {
        $format = "SELECT+%s+from+%s";
        $query = sprintf($format, implode(',', $fields), $from);

        // add conditions
        if (is_array($conditions) && !empty($conditions)) {
            $where = "+where+%s";

            if ($this->isConditionsSimple($conditions)) {
                $cond = [];
                foreach ($conditions as $key => $condition) {
                    $cond[] = $key . '+' . '=' . '+\'' . $condition .'\'';
                }
            } else {
                $cond = $conditions;
            }
            $cond = implode('+and+', $cond);
            $cond = str_replace(' ', '+', $cond);
            $query = $query . sprintf($where, $cond);
        }
        return $query;
    }

    /**
     * @param $conditions
     * @return bool
     */
    private function isConditionsSimple($conditions)
    {
        $imploded = implode('',$conditions);
        return ( $this->contains($imploded, self::CONDITION_OPERATORS) == false );
    }

    /**
     * @param $str
     * @param array $arr
     * @return bool
     */
    private function contains($str, array $arr)
    {
        foreach($arr as $a) {
            if (stripos($str, $a) !== false) {
                return true;
            }
        }
        return false;
    }

}