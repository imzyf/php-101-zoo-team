<?php
/*
最长回文子串
给定一个字符串 s，找到 s 中最长的回文子串。你可以假设 s 的最大长度为 1000。

示例
输入: "babad"
输出: "bab"
注意: "aba" 也是一个有效答案。
 */
class n10_longest_palindrome
{/*
动态规划的思想，是希望把问题划分成相关联的子问题；然后从最基本的子问题出发来推导较大的子问题，直到所有的子问题都解决。

根据字符串的长度，建立一个矩阵 dp, 通过不同情况的判断条件，通过 dp[i][j] 表示 s[i] 至 s[j] 所代表的子串是否是回文子串


*/

    public static function dynamic(string $str): string
    {
        $dp = [];
        $strLen = strlen($str);

        $max = -1;
        $maxStr = '';
        for ($l = 0; $l < $strLen; ++$l) {
            // l为所遍历的子串长度 - 1，即左下标到右下标的长度
            for ($i = 0; $i + $l < $strLen; ++$i) {
                $j = $i + $l;
                // i为子串开始的左下标，j为子串开始的右下标
                if (0 === $l) {
                    // 当子串长度为1时，必定是回文子串
                    $dp[$i][$j] = true;
                } elseif ($l <= 2) {
                    // 长度为2或3时，首尾字符相同则是回文子串
                    $dp[$i][$j] = $str[$i] === $str[$j];
                } else {
                    // 长度大于3时，若首尾字符相同且去掉首尾之后的子串仍为回文，则为回文子串
                    if ($str[$i] === $str[$j] && $dp[$i + 1][$j - 1]) {
                        $dp[$i][$j] = true;
                    } else {
                        $dp[$i][$j] = false;
                    }
                }
                if ($dp[$i][$j] && $l > $max) {
                    $max = $l;
                    $maxStr = substr($str, $i, $l + 1);
                }
            }
        }

        /*

        dp is

           b  a  b  a  d
           0  1  2  3  4
        0  v
        1  x  v
        2  v  x  v
        3  x  v  x  v
        4  x  x  x  x  v

        程序填写顺序 右上到左下 ↙，一斜列一斜列

         */

        return $maxStr;
    }

    public static function center(string $str): string
    {
        $strLen = strlen($str);

        if ($strLen < 2) {
            return $str;
        }

        // $left 左起点
        // $left 右起点
        $func = static function ($str, $left, $right) {
            while ($left >= 0 && $right < strlen($str) && $str[$left] === $str[$right]) {
                --$left;
                ++$right;
            }
            // 不满足了 也就是多处理了一次
            // 也就是取 ($left, $right) 之间的数
            // 1 2 3 4 5 6
            //   _     _    5 -2 -1
            //     _   _    5 -3 -1
            //
            return $right - $left - 1;
        };

        $max = -1;
        $maxStr = '';
        foreach (str_split($str) as $i => $v) {
            $len1 = $func($str, $i, $i);
            $len2 = $func($str, $i, $i + 1);
            $len = max($len1, $len2);
            // 如果此位置为中心的回文数长度大于之前的长度，则进行处理

            if ($max < $len) {
                $max = $len;
                // 起始 offset 如何计算
                // 0 1 2 3 4 5
                // a b c d c d
                //       _      长度3
                //
                //
                // 0 1 2 3 4 5
                // a b c c d e
                //     _        长度2
                //
                // 0 1 2 3 4 5
                // b a a a a b
                //     _        长度6
                //
                // TODO 这里 (len - 1)/2 还有没搞清楚
                $maxStr = substr($str, $i - ($len - 1) / 2, $len);
            }
        }

        return $maxStr;
    }
}

/* check */
$test = [
    ['aabad', 'aba'],
    ['baabaada', 'aabaa'],
    ['a', 'a'],
    ['aa', 'aa'],
    ['bab', 'bab'],
    ['abba', 'abba'],
    ['abvba', 'abvba'],
    ['', ''],
    ['abcd', 'a'],
];

foreach ($test as [$strs,   $check]) {
    $ret = n10_longest_palindrome::dynamic($strs);
    $is = $check === $ret ? 'true' : 'false';
    echo "dynamic: {$is} {$ret}\n";

    $ret = n10_longest_palindrome::center($strs);
    $is = $check === $ret ? 'true' : 'false';
    echo "center:  {$is} {$ret}\n";
}
