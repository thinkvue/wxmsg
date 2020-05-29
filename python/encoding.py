"""
  : Author: MiDoFa
  : Date: 2019-07-08 16:13:54
 :LastEditors: lijian@midofa.com
 :LastEditTime: 2020-05-02 10:02:15
  : Description: 项目描述
"""
from cryptography.fernet import Fernet
import random
import string
import re


def random_string(length, mode=1):
    """生成随机字符串
    :param length:长度
    :param mode=1：1生成可用于命名文件和变量的客串，2生成包含大小写数字的密码(最低3位)，3生成除控制符外的随机客串"""
    if length < 1:
        return ""
    if mode == 1:
        if length == 1:
            return "".join(random.choices(string.ascii_letters, k=length))
        return "".join(random.choices(string.ascii_letters, k=1)) + "".join(
            random.choices(string.ascii_letters + string.digits, k=length - 1)
        )
    elif mode == 2:
        if length >= 3:
            uppercase_num = random.randint(1, length - 2)
            lowercase_num = random.randint(1, length - uppercase_num - 1)
            digits_num = length - lowercase_num - uppercase_num
        else:
            uppercase_num = 1
            lowercase_num = 1
            digits_num = 1
        password = (
            random.choices(string.digits, k=digits_num)
            + random.choices(string.ascii_uppercase, k=uppercase_num)
            + random.choices(string.ascii_lowercase, k=lowercase_num)
        )
        random.shuffle(password)
        return "".join(password)
    else:
        return "".join(
            random.choices(
                "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~",
                k=length,
            )
        )


def encode(plain_text, key=b"wx-UTFs_94JltM6fZRrkygNT6gWXxXpoQ4P-YXCqBaA="):
    """加密
    :param plain_text 需要加密的明文
    :param key 密码，要求32位+url-safe+base64-encoded的bytes类型，默认为wx-UTFs_94JltM6fZRrkygNT6gWXxXpoQ4P-YXCqBaA="""
    factory = Fernet(key)
    token = factory.encrypt(plain_text.encode()).decode()
    return token


def decode(cipher_text, key=b"wx-UTFs_94JltM6fZRrkygNT6gWXxXpoQ4P-YXCqBaA="):
    """解密
    :param cipher_text 需要解密的密文
    :param key 密码，要求32位+url-safe+base64-encoded的bytes类型，默认为wx-UTFs_94JltM6fZRrkygNT6gWXxXpoQ4P-YXCqBaA="""
    factory = Fernet(key)
    string = factory.decrypt(cipher_text.encode()).decode()
    return string


def to_unicode(html):
    """把HTML代码中unicode十进制编码转换为内码（含中英文)"""
    return re.sub(r"&#(\d{1,5});", lambda ma: chr(int(ma.group(1))), html)


def format_url(url):
    """把url标准格式化"""
    if not (
        re.match(r"http(?:s)?\://(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?(?:/[^?]+)\?(?:[^=]+=[^&]*&?)+", url)
    ):
        return url
    ret, para = url.split("?", maxsplit=1)
    tmp_dict = {}
    for tmp in para.split("&"):
        key, value = tmp.split("=", 1)
        if key not in ["spm"]:  # 忽略url中的某些参数
            tmp_dict[key] = value
    ret = ret + "?"
    for tmp in sorted(tmp_dict.keys()):
        ret = "%s%s=%s&" % (ret, tmp, tmp_dict[tmp])
    return ret[:-1]


if __name__ == "__main__":
    # 测试
    string = '1577721600'
    print("明文：%s\n密文：%s\n解密：%s\n"%(string,encode(string),decode(encode(string))))
    string = 'http://lic.midofa.com/licence.php?userid=%s'
    print("明文：%s\n密文：%s\n解密：%s\n"%(string,encode(string),decode(encode(string))))
    string = '我爱你'
    print("明文：%s\n密文：%s\n解密：%s\n"%(string,encode(string),decode(encode(string))))
    print(
        format_url(
            "https://detail.tmall.com/item.htm?spm=a1z10.3-b.w4011-1"
            "7873937882.119.2dd55cc1dTxN8q&id=564833337122&rn=254fea0143cab2ebe343cf4ce5ee0c30&abbucket=3"
        )
    )
    print(format_url("https://www.taobao.com/"))
    print(format_url("http://localhost.cn/phpMyAdmin4.8.5/sql.php?server=1&db=mgipr&table=midofa_spider_history&pos=0"))
    print(format_url("http://www.jk-lawyer.com/news.php?id=1&page=45"))
    print(
        format_url(
            "http://search.chinalaw.gov.cn/law/searchTitleDetail?LawID=404174&Query=%E5%8C%BB&IsExact=&PageIndex=2"
        )
    )
    print(to_unicode("中国人&#52222;"))
