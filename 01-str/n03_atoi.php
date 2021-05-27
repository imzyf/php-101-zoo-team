<?php

/*
 字符串转换整数
atoi (表示 ascii to integer)是把字符串转换成整型数的一个函数，实现一个 atoi 函数，使其能将字符串转换成整数。
首先，该函数会根据需要丢弃无用的开头空格字符，直到寻找到第一个非空格的字符为止。
当我们寻找到的第一个非空字符为正或者负号时，则将该符号与之后面尽可能多的连续数字组合起来，作为该整数的正负号；假如第一个非空字符是数字，则直接将其与之后连续的数字字符组合起来，形成整数。
该字符串除了有效的整数部分之后也可能会存在多余的字符，这些字符可以被忽略，它们对于函数不应该造成影响。
注意：假如该字符串中的第一个非空格字符不是一个有效整数字符、字符串为空或字符串仅包含空白字符时，则你的函数不需要进行转换。
在任何情况下，若函数不能进行有效的转换时，请返回 0。

示例 1:
输入: "42"
输出: 42
示例 2:
输入: "-42"
输出: -42
示例 3:
输入: "4193 with words"
输出: 4193
示例 4:
输入: "words and 987"
输出: 0
示例 5:
输入: "-91283472332"
输出: -2147483648

说明：
你可以假设给定的 k 总是合理的，且 1 ≤ k ≤ 数组中不相同的元素的个数。 你的算法的时间复杂度必须优于  ,  是数组的大小。
 */
class n03_atoi
{
    public static function toByPreg($str): int
    {
        $str = trim($str, ' ');
        preg_match("/^[-+]?\d+/", $str, $matches);

        if (empty($matches)) {
            return 0;
        }

        return (int) $matches[0];
    }

    public static function toByVal($str): int
    {
        return (int) $str;
    }
}

/* check */
$test = [
    ['4193 with words', 4193],
    ['words and 987', 0],
    ['-42', -42],
    [' -42  ', -42],
    [' +421 ', 421],
    ['-912834723327233272332', PHP_INT_MIN],
];

foreach ($test as [$str, $check]) {
    $ret = n03_atoi::toByPreg($str);
    $is = $check === $ret ? 'true' : 'false';
    echo "toByPreg: {$is} {$str} {$ret}\n";

    $ret = n03_atoi::toByVal($str);
    $is = $check === $ret ? 'true' : 'false';
    echo "toByVal:  {$is} {$str} {$ret}\n";
}
