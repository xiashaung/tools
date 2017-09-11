<?php
namespace Tools\traits;

/**
 * Class crypt
 * @package Tools\traits
 */
trait crypt
{
    /**
     * @param string $pwd  需要加密的字符串
     * @param array $arr salt 加盐  cost递归层数
     * @return bool|string
     */
     public  static  function crypt_encode(string $pwd,$algo,array $arr = ['cost'=>10])
     {
         return password_hash($pwd,$algo,$arr);
     }

    /**
     * 验证输入的字符串的正确or错误
     * @param string $pwd  需要验证的字符串
     * @param string $hash 加密的字符串
     * @return bool
     */
     public  static function crypt_decode(string $pwd, string  $hash)
     {
           return password_verify($pwd,$hash);
     }

    /**
     * 刷新当前加密hash
     * @param string $pwd  需要加密的字符串l
     * @param array $arr salt 加盐  cost递归层数
     * @return string
     */
    public static function crypt_rehash( string $hash,$algo, array $arr = ['cost'=>10])
    {
        return password_needs_rehash($hash,$algo,$arr) ;
    }
}