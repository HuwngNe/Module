<?php

namespace Ecommage\BuyTogether\Ui\Component\Listing\Column\Pack;

use Magento\Ui\Component\Listing\Columns\Column;

class PercentCustom  extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        for ($i = 0; $i < count($dataSource["data"]["items"]); $i++) {
            $dataSource["data"]["items"][$i]["percentT"] = $dataSource["data"]["items"][$i]["percent"]."%";
        }

        return $dataSource;
    }
}
