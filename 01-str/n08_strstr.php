<?php

/*
给定一个 haystack 字符串和一个 needle 字符串，在 haystack 字符串中找出 needle 字符串出现的第一个位置 (从0开始)。如果不存在，则返回 -1。
以下称 haystack 字符串为匹配字符串，needle 字符串为查找字符串
示例
给定 haystack = 'hello world', needle = 'll'

返回2

说明:
当 needle 是空字符串时，我们应当返回什么值呢？这是一个在面试中很好的问题。
对于本题而言，当 needle 是空字符串时我们应当返回 0 。这与C语言的 strstr() 以及 Java的 indexOf() 定义相符。
 */
class n08_strstr
{
    // n2
    public static function strpos(string $haystack, string $handle): int
    {
        if ('' === $handle) {
            // PHP Warning:  strpos(): Empty needle in
            return 0;
        }

        foreach (str_split($haystack) as $idx => $v) {
            if ($v !== $handle[0]) {
                continue;
            }

            if (1 === strlen($handle)) {
                return $idx;
            }

            $handleIdx = 1;
            $allSame = true;
            // 变量剩下的 handle
            while ($handleIdx < strlen($handle)) {
                $handleChar = $handle[$handleIdx];
                $haystackChar = $haystack[$idx + $handleIdx] ?? null;
                ++$handleIdx;

                // 有一个错误就是错误
                if ($handleChar !== $haystackChar) {
                    $allSame = false;
                    break;
                }
            }

            if ($allSame) {
                return $idx;
            }
        }

        return -1;
    }

    public static function strposByN(string $haystack, string $handle): int
    {
        $hayLen = strlen($haystack);
        $handLen = strlen($handle);

        if ('' === $handle) {
            // PHP Warning:  strpos(): Empty needle in
            return 0;
        }

        if ($hayLen < $handLen) {
            return -1;
        }
        if ($hayLen === $handLen) {
            return $haystack === $handle ? 0 : -1;
        }

        // 此处需要注意的是，当 haystack 剩余字符串长度小于 needle 长度时，肯定是不相等，无需再次比较。
        // 在遍历中判断 将要截取的字符串的首位与 needle 字符串的首位是否相同 ，如果不相同也就不需要后续截取、比较，跳过该次循环
        for ($idx = 0; $idx <= $hayLen - $handLen; ++$idx) {
            if ($haystack[$idx] !== $handle[0]) {
                continue;
            }
            if (substr($haystack, $idx, $handLen) === $handle) {
                return $idx;
            }
        }

        return -1;
    }
}

/* check */
$test = [
    ['hello world', 'll', 2],
    ['hello world', 'zz', -1],
    ['hello world', 'l', 2],
    ['hello world', 'or', 7],
    ['baa', 'baaa', -1],
    ['caa', 'caa', 0],
    ['caa', '0', -1],
];

foreach ($test as [$strs, $handle, $check]) {
    $ret = n08_strstr::strpos($strs, $handle);
    $is = $check === $ret ? 'true' : 'false';
    echo "strpos:     {$is} {$ret}\n";

    $ret = n08_strstr::strposByN($strs, $handle);
    $is = $check === $ret ? 'true' : 'false';
    echo "strposByN:  {$is} {$ret}\n";
}
