<?php

/*
 验证回文串
给定一个字符串，验证它是否是回文串，只考虑字母和数字字符，可以忽略字母的大小写。
说明：本题中，我们将空字符串定义为有效的回文串。

输入: "A man, a plan, a canal: Panama"
输出: true

输入: "race a car"
输出: false

正读翻读都一样

*/
class n07_valid_palindrome
{
    // O(n) O(n)
    public static function valid(string $str): bool
    {
        preg_match_all('/[A-z|0-9]/', $str, $matches);

        $clear = [];
        if (!empty($matches)) {
            $clear = $matches[0];
        }

        $idx = 0;
        while ($idx < count($clear) / 2) {
            if (strtoupper($clear[$idx]) !== strtoupper($clear[count($clear) - 1 - $idx])) {
                return false;
            }

            ++$idx;
        }

        return true;
    }

    public static function validRev(string $str): bool
    {
        preg_match_all('/[A-z|0-9]/', $str, $matches);

        $clear = '';
        if (!empty($matches)) {
            $clear = implode('', $matches[0]);
        }

        return strtoupper($clear) === strtoupper(strrev($clear));
    }
}

/* check */
$test = [
    ['A man, a plan, a canal: Panama', true],
    ['a', true],
    ['a13a', false],
    ['a13a31a', true],
    ['race a car', false],
];

foreach ($test as [$strs, $check]) {
    $ret = n07_valid_palindrome::valid($strs);
    $is = $check === $ret ? 'true' : 'false';
    echo "valid:    {$is} {$ret}\n";

    $ret = n07_valid_palindrome::validRev($strs);
    $is = $check === $ret ? 'true' : 'false';
    echo "validRev: {$is} {$ret}\n";
}
