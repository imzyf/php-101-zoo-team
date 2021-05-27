<?php
/*
 有效的字母异位词

给定两个字符串 s 和 t ，编写一个函数来判断 t 是否是 s 的字母异位词。

输入: s = "anagram", t = "nagaram"
输出: true

输入: s = "rat", t = "car"
输出: false
 */
class n02_same_word
{
    /*
     方法一 利用数组sort()方法

   思路
首先，对字符串字母进行排序，然后，比较两字符串是否相等。
详解
首先，将字符串转为数组。
利用数组 sort 方法进行排序。
然后，转为字符串进行比较，如果相等返回 true，反之返回 false。
     */
    public static function sameBySort($s, $t): bool
    {
        /*
        if (strlen($s) !== strlen($t)) {
            return false;
        }
        */
        $sa = str_split($s);
        $ta = str_split($t);
        sort($sa);
        sort($ta);
        /*
        foreach ($sa as $k => $v) {
            if ($v !== $ta[$k]) {
                return false;
            }
        }
        */
        $sa = implode('', $sa);
        $ta = implode('', $ta);

        return $sa === $ta;
    }
/*
 时间复杂度：
算法中使用了 2 个单层循环，因此，时间复杂度为 。

空间复杂度：
申请的变量 hash 最大长度为 256，因为 Ascii 字符最多 256 种可能，因此，考虑为常量空间，即 。
 */
    public static function sameByCount($s, $t): bool
    {
        // 补充
        if (strlen($s) !== strlen($t)) {
            return false;
        }

        $sa = str_split($s);
        $ta = str_split($t);
        $map = [];
        /*
        foreach ($sa as $k => $v) {
            if (isset($map[$v])) {
                ++$map[$v];
            } else {
                $map[$v] = 1;
            }
        }
        */
        foreach ($sa as $k => $v) {
            $map[$v] = $map[$v] ?? 0;
            ++$map[$v];
        }

        /*
        foreach ($ta as $k => $v) {
            if (isset($map[$v])) {
                --$map[$v];
            } else {
                return false;
            }
        }

        foreach ($map as $k => $v) {
            if (0 !== $v) {
                return false;
            }
        }
        */

        foreach ($ta as $k => $v) {
            if (isset($map[$v]) && $map[$v] > 0) {
                --$map[$v];
            } else {
                return false;
            }
        }

        return true;
    }
}

/* check */
$test = [
  ['anagram', 'nagaram', true],
  ['anagram', 'anagran', false],
  ['aa', 'a', false],
  ['a', 'aa', false],
  ['rat', 'car', false],
];

foreach ($test as [$s, $t, $check]) {
    $ret = n02_same_word::sameBySort($s, $t);
    $is = $check === $ret ? 'true' : 'false';
    echo "sameBySort: {$is} {$s} {$t} \n";

    $ret = n02_same_word::sameByCount($s, $t);
    $is = $check === $ret ? 'true' : 'false';
    echo "sameByCount: {$is} {$s} {$t} \n";
}
