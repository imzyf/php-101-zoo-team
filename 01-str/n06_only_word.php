<?php
/*
 字符串中的第一个唯一字符

给定一个字符串，找到它的第一个不重复的字符，并返回它的索引。如果不存在，则返回 -1。

s = "leetcode"
返回 0.

s = "loveleetcode",
返回 2.
 */
class n06_only_word
{
    public static function only(string $str): int
    {
        $map = [];
        foreach (str_split($str) as $v) {
            $count = $map[$v] ?? 0;
            ++$count;
            $map[$v] = $count;
        }

        $idx = 0;
        foreach ($map as $count) {
            if (1 === $count) {
                return $idx;
            }
            ++$idx;
        }

        return -1;
    }

    public static function startAndEnd(string $str): int
    {
        $idx = 0;
        while ($idx < strlen($str)) {
            // 这是不对的 如果之前找不到 到最后一个一定可以了 但是可能已经重复了
            // if (strrpos($str, $str[$idx]) === $idx) {
            if (strrpos($str, $str[$idx]) === strpos($str, $str[$idx])) {
                return $idx;
            }

            ++$idx;
        }

        return -1;
    }
}

/* check */
$test = [
    ['leetcode', 0],
    ['loveleetcode', 2],
    ['s', 0],
    ['sss', -1],
];

foreach ($test as [$strs, $check]) {
    $ret = n06_only_word::only($strs);
    $is = $check === $ret ? 'true' : 'false';
    echo "rev:         {$is} {$ret}\n";

    $ret = n06_only_word::startAndEnd($strs);
    $is = $check === $ret ? 'true' : 'false';
    echo "startAndEnd: {$is} {$ret}\n";
}
