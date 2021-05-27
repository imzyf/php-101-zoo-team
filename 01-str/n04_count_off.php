<?php

/*
 报数
报数序列是一个整数序列，按照其中的整数的顺序进行报数，得到下一个数。其前五项如下：
1.     1
2.     11
3.     21
4.     1211
5.     111221

1 被读作 "one 1" ("一个一") , 即 11。 11 被读作 "two 1s" ("两个一"）, 即 21。 21 被读作 "one 2", "one 1" （"一个二" , "一个一") , 即 1211。111221 312211

给定一个正整数 n（1 ≤ n ≤ 30），输出报数序列的第 n 项。
注意：整数顺序将表示为一个字符串。 示例
输入: 1
输出: "1"
输入: 4
输出: "1211"
 */
class n04_count_off
{
    public static function byStack(int $no): string
    {
        if (1 === $no) {
            return '1';
        }

        $preNum = static::byStack($no - 1);

        //[[数字，个数]，[数字，个数]]
        $stack = [];
        foreach (str_split($preNum) as $v) {
            // 数字
            $v = (int) $v;
            $last = end($stack);
            if (false !== $last) {
                // 有值 && 还是之前的
                [$_val, $_count] = $last;
                if ($_val === $v) {
                    // last
                    $stack[count($stack) - 1] = [$_val, ++$_count];
                    continue;
                }
            }

            // 首次记录
            $stack[] = [$v, 1];
        }

        $ret = '';
        foreach ($stack as [$_val, $_count]) {
            $ret .= "{$_count}{$_val}";
        }

        return $ret;
    }

    public static function byPreg(int $no): string
    {
        if (1 === $no) {
            return '1';
        }
        $preNum = static::byPreg($no - 1);

        // https://regex101.com/codegen?language=php
        // '/(\d)\1*/' is diff "/(\d)\1*/"
        // preg_match_all is /xxx/g

        /*
         * \d 匹配一个数字
         * \1 匹配前面第一个括号内匹配到的内容
         * (\d)\1* 匹配相邻数字相同的内容
         * 使用replace方法将匹配到的内容处理为长度 + 内容的第一个字符
         * 结果为所求报数
         **/
        return preg_replace_callback('/(\d)\1*/', static function ($matches) {
            return strlen($matches[0]).$matches[1];
        }, $preNum);
    }

    // O(n) O(1)
    public static function byEachPreg(int $no): string
    {
        if (1 === $no) {
            return '1';
        }
        $idx = 1;
        $ret = '1';
        while ($no > $idx) {
            $ret = preg_replace_callback('/(\d)\1*/', static function ($matches) {
                return strlen($matches[0]).$matches[1];
            }, $ret);
            ++$idx;
        }

        return $ret;
    }
}

/* check */
$test = [
    [1, '1'],
    [2, '11'],
    [3, '21'],
    [4, '1211'],
    [5, '111221'],
    [6, '312211'],
    [7, '13112221'],
];

foreach ($test as [$no, $check]) {
    $ret = n04_count_off::byStack($no);
    $is = $check === $ret ? 'true' : 'false';
    echo "byStack:    {$is} {$ret}\n";

    $ret = n04_count_off::byPreg($no);
    $is = $check === $ret ? 'true' : 'false';
    echo "byPreg:     {$is} {$ret}\n";

    $ret = n04_count_off::byEachPreg($no);
    $is = $check === $ret ? 'true' : 'false';
    echo "byEachPreg: {$is} {$ret}\n";
}
