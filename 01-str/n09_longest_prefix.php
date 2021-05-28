<?php

/*
 最长公共前缀

编写一个函数来查找字符串数组中的最长公共前缀。
如果不存在公共前缀，返回空字符串 ""。
示例
输入: ["flower","flow","flight"]
输出: "fl"
 */
class n09_longest_prefix
{
    /*
     时间：n 我之前里的
    空间：1
     */
    public static function prefix($strs): string
    {
        if (1 === count($strs)) {
            return '';
        }

        $samePrefixByTwo = static function (string $s, string $t): string {
            $sLen = strlen($s);
            $tLen = strlen($t);
            $sameIdx = -1;
            for ($i = 0; $i < min($sLen, $tLen); ++$i) {
                if ($s[$i] === $t[$i]) {
                    $sameIdx = $i;
                } else {
                    break;
                }
            }

            return -1 === $sameIdx ? '' : substr($s, 0, $sameIdx + 1);
        };

        $preStr = $strs[0];
        for ($i = 1, $iMax = count($strs); $i < $iMax; ++$i) {
            $preStr = $samePrefixByTwo($preStr, $strs[$i]);
        }

        return $preStr;
    }
}

/* check */
$test = [
    [['flower', 'flow', 'flight'], 'fl'],
    [['fx', 'flow', 'flight'], 'f'],
    [['lower', 'flow', 'flight'], ''],
    [['lower', 'lower', 'lower'], 'lower'],
];

foreach ($test as [$strs,   $check]) {
    $ret = n09_longest_prefix::prefix($strs);
    $is = $check === $ret ? 'true' : 'false';
    echo "prefix: {$is} {$ret}\n";
}
