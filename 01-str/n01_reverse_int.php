<?php

/*
给出一个 32 位的有符号整数，你需要将这个整数中每位上的数字进行反转。

示例 1:
输入: 123
输出: 321

示例 2:
输入: -123
输出: -321

示例 3:
输入: 120
输出: 21

注意:
假设我们的环境只能存储得下 32 位的有符号整数，则其数值范围为 。请根据这个假设，如果反转后整数溢出那么就返回 0。
 */
class n01_reverse_int
{
    /*
     方法一 翻转字符串方法

    思路
    如果将数字看成是有符号位的字符串，那么我们就能够通过使用 JS 提供的字符串方法来实现非符号部分的翻转，又因为整数的翻转并不影响符号，所以我们最后补充符号，完成算法。

    详解
首先设置边界极值；
使用字符串的翻转函数进行主逻辑；
补充符号
然后拼接最终结果

    https://www.php.net/manual/zh/function.intval.php
    */
    public static function reverseByStr(int $num): int
    {
        if ($num > 0) {
            $rest = (int) strrev($num);
        } else {
            // 截取负号
            $rest = substr($num, 1);
            $rest .= '-';
            $rest = (int) strrev($rest);
        }

        return $rest;
    }

    /*
     方法二 类似 欧几里得算法 求解

    思路
    我们借鉴欧几里得求最大公约数的方法来解题。符号的处理逻辑同方法一，这里我们通过模 10 取到最低位，然后又通过乘 10 将最低位迭代到最高位，完成翻转。

    详解
    设置边界极值；
    取给定数值的绝对值，遍历循环生成每一位数字，借鉴欧几里得算法，从 num 的最后一位开始取值拼成新的数
    同步剔除掉被消费的部分
    如果最终结果为异常值，则直接返回 0；如果原本数据为负数，则对最终结果取反
    返回最终结果
     */
    public static function reverseByOjl(int $num): int
    {
        $abs = abs($num);
        $rev = 0;
        while (0 !== $abs) {
            $rev = $abs % 10 + $rev * 10;
            $abs /= 10;
            // 防止变成 float
            $abs = (int) $abs;
        }

        // 变成了 float
        if ($rev > PHP_INT_MAX) {
            return $num > 0 ? PHP_INT_MAX : PHP_INT_MIN;
        }

        return $num > 0 ? $rev : $rev * -1;
    }
}

/* check */
$test = [
    [123321456, 654123321],
    [-123320456, -654023321],
    [-123300, -3321],
    [1233000, 3321],
    [-1223372036854775899, PHP_INT_MIN],
];
foreach ($test as [$num, $check]) {
    $ret = n01_reverse_int::reverseByStr($num);
    $is = $check === $ret ? 'true' : 'false';
    echo "reverseByStr: {$is} {$num} {$ret} \n";

    $ret = n01_reverse_int::reverseByOjl($num);
    $is = $check === $ret ? 'true' : 'false';
    echo "reverseByOjl: {$is} {$num} {$ret} \n";
}
