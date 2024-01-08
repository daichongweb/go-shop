<?php

namespace App\Http\Utils;

class StringUtil
{
    public static function generateRandomChineseNickname($minLength = 4, $maxLength = 6): string
    {
        // 一个包含常用汉字的数组
        $chineseCharacters = ['爱', '笑', '明', '智', '勇', '善', '和', '平', '静', '雅', '光', '花', '海', '天', '星', '心', '炎', '风', '雨', '山', '河', '林', '月', '日', '梦', '希', '望', '龙', '凤', '鸟', '翔', '舞', '歌', '泉', '石', '木', '枫', '桥', '城', '国', '美', '宝', '珠', '玉', '金', '银', '丝', '绸', '红', '橙', '黄', '绿', '蓝', '靛', '紫', '白', '黑', '灰', '茶'];

        // 随机选择昵称的长度
        $length = rand($minLength, $maxLength);

        // 生成昵称
        $randomNickname = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNickname .= $chineseCharacters[array_rand($chineseCharacters)];
        }

        return $randomNickname;
    }
}
