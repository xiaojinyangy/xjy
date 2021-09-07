<?php
namespace app\NewClass\KeywordFilter;

use app\NewClass\KeywordFilter\Tools\ToTree;
use app\NewClass\KeywordFilter\Service\searchBadWords;

/*
 * 敏感词过滤，基于DFA敏感词过滤算法，大字典的时候比较高效。
 * 使用只需要将本文件引入，然后再调用shildDirtyWords::findAndHideKeyWords($testWords)即可
 * 如果使用shildDirtyWords::findAndHideKeyWords($testWords)来屏蔽，会有比较好的屏蔽效果，
 * 这个是对字典的补充，忽略了一些无意义的词，但也可能造成语义的一点曲解。注意斟酌使用
 * 需要及时更新敏感词字典，敏感词字典在/Resources/BadWord.txt
 */

/**
 * 屏蔽关键词
*/
class KeywordFilter 
{
     
    //引入过滤词库
    private static $badWordsUrl=__DIR__.'/Resources/BadWord.txt';

    /**
     * 忽略所有(空格,`,~,#,$,^,&,*,_),并且自动将敏感词更换为*
     * @param type $needToCheckWords
     * @return type
     */
    public static function find($text) 
    {
        //格式化关键词脏话字典为DFA map树
        $treeModel = new ToTree(self::$badWordsUrl);
        //获取map进行关键词匹配
        $searchModel=new searchBadWords($treeModel->getMap());
        return $searchModel->findAndHideKeyWords($text);
    }
    
    //添加过滤词 
    public static function add($field)
    {    
        $text=self::$badWordsUrl;
        if(file_exists($text))
        {
            //"当前目录中，文件存在"，追加
            $myfile = fopen($text, "a");
            $txt = "\n$field";
            $row=fwrite($myfile, $txt);
            //记得关闭流
            fclose($myfile);
            return $row;
        }
        else
        {
            //"当前目录中，文件不存在",新写入
            $myfile = fopen($text, "w");
            $txt = "\n$field";
            $row=fwrite($myfile, $txt);
            //记得关闭流
            fclose($myfile);
            return $row;
        }
    }

}
