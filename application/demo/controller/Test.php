<?php
/*
 * @Author: lijian@midofa.com
 * @URL: http://midofa.com
 * @Date: 2020-05-15 17:07:18
 * @LastEditors: lijian@midofa.com
 * @LastEditTime: 2020-05-16 01:45:15
 * @FilePath: \\api.thinkvue.com\\application\\demo\\controller\\Test.php
 * @Description:  
 */ 
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------

namespace app\demo\controller;

use app\common\controller\Common;

class Test extends Common
{
    public function index(){
        echo "Hello";
    }

    public function get(){
    //     echo "Hello!";
    // }

    // public function list()
    // {
        // echo "OK";
        $key=input("key");
        if($key=="userInfo"){
            $data = [
                "status"	=> 1,
                "data"	=> [
                    "id"	=> 1,
                    "mobile"	=> 18888888888,
                    "nickname"	=> 'ThinkVue',
                    "portrait"	=> 'https://api.thinkvue.cn/static/demo/img/MtiIVB5rTPAj4sRowGn2NueOSQKdWlzL.jpg'
                ],
                "msg"	=> '提示'
            ];
        }elseif($key=="carouselList"){
            $data = [[
                    "src"	=> "/static/temp/banner3.jpg",
                    "background"	=> "rgb(203, 87, 60)",
                ],
                [
                    "src"	=> "/static/temp/banner2.jpg",
                    "background"	=> "rgb(205, 215, 218)",
                ],
                [
                    "src"	=> "/static/temp/banner4.jpg",
                    "background"	=> "rgb(183, 73, 69)",
                ]
            ];
        }elseif($key=="goodsList"){
            $data = [[
                    "image"	=> "https://api.thinkvue.cn/static/demo/img/aCvBDOeNnKb3xcJQHEYtuZhIGPFUMWli.jpeg",
                    "image2"	=> "https://api.thinkvue.cn/static/demo/img/DYGfTEpmZdHwbOuaMSWyi54jtAnrhgIc.jpeg",
                    "image3"	=> "https://api.thinkvue.cn/static/demo/img/KFViOAc2YkEyHpX57ugUWNzmRde9xDLw.jpg",
                    "title"	=> "古黛妃 短袖t恤女夏装2019新款韩版宽松",
                    "price"	=> 179,
                    "sales"	=> 61,
                ],
                [
                    "image"	=> "https://api.thinkvue.cn/static/demo/img/0Bry84GX9WMhbCajeYOvkoSJs2VqDHQN.jpg",
                    "image2"	=> "https://api.thinkvue.cn/static/demo/img/i6QpDdacHOn37KREv1yuxtwIMmlTG09P.jpg",
                    "image3"	=> "https://api.thinkvue.cn/static/demo/img/NpDTHatwOPWRFAd0rEsxjX7KeICZ2h1m.jpg",
                    "title"	=> "潘歌针织连衣裙",
                    "price"	=> 78,
                    "sales"	=> 16,
                ],
                [
                    "image"	=> "https://api.thinkvue.cn/static/demo/img/XRO2w8uFnBbQ3UCg71koNJKEhzeqc6yt.jpg",
                    "image2"	=> "https://api.thinkvue.cn/static/demo/img/18gCK5FmfIA0GTdPURSJzDBc97MVvsor.jpg",
                    "image3"	=> "https://api.thinkvue.cn/static/demo/img/notfound.jpg",
                    "title"	=> "巧谷2019春夏季新品新款女装",
                    "price"	=> 108.8,
                    "sales"	=> 5,
                ], [
                    "image"	=> "https://api.thinkvue.cn/static/demo/img/39YrE04SKkDTNMU17JeuLfWjmG8oycBg.jpg",
                    "image2"	=> "https://api.thinkvue.cn/static/demo/img/0Cmk3J1TdxgGrMfX2u5RaQYZnz6ehiHb.jpg",
                    "image3"	=> "https://api.thinkvue.cn/static/demo/img/lk7sAzteaXJYr8vGoC49y0DuWPwhEBcQ.jpg",
                    "title"	=> "私萱连衣裙",
                    "price"	=> 265,
                    "sales"	=> 88,
                ], [
                    "image"	=> "https://api.thinkvue.cn/static/demo/img/qv1PETIyw5zYSdsp9MDRQZnHFUkOiAV6.jpg",
                    "image2"	=> "https://api.thinkvue.cn/static/demo/img/p0H138FNWxjAMbCJdKhwogLGOre7YmyR.jpg",
                    "image3"	=> "https://api.thinkvue.cn/static/demo/img/notfound.jpg",
                    "title"	=> "娇诗茹 ulzzang原宿风学生潮韩版春夏短",
                    "price"	=> 422,
                    "sales"	=> 137,
                ], [
                    "image"	=> "https://api.thinkvue.cn/static/demo/img/aCvBDOeNnKb3xcJQHEYtuZhIGPFUMWli.jpeg",
                    "image2"	=> "https://api.thinkvue.cn/static/demo/img/GxS9FM4wQlCDBPIdafbcWiT2UoXRjKt6.jpg",
                    "image3"	=> "https://api.thinkvue.cn/static/demo/img/Ha7O8Wi5tLrVN4Awxozg16MkCTSsYvlp.jpg",
                    "title"	=> "古黛妃 短袖t恤女夏装2019新款韩版宽松",
                    "price"	=> 179,
                    "sales"	=> 95,
                ],
            ];
        }elseif($key=="cartList"){
            $data = [[
                    "id"	=> 1,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/HkGred0DhlsRuYwFKn3XP6j8ZAWm2QU1.jpg',
                    "attr_val"	=> '春装款 L',
                    "stock"	=> 15,
                    "title"	=> 'OVBE 长袖风衣',
                    "price"	=> 278.00,
                    "number"	=> 1
                ],
                [
                    "id"	=> 3,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/4v8Et92Z1lg5SskwOCUuDjQ6IFycaLGe.jpg',
                    "attr_val"	=> '激光导航 扫拖一体',
                    "stock"	=> 3,
                    "title"	=> '科沃斯 Ecovacs 扫地机器人',
                    "price"	=> 1348.00,
                    "number"	=> 5
                ],
                [
                    "id"	=> 4,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/RN9m8DSn3g7zyAWp2J5OZvPjXfrucxBF.jpg',
                    "attr_val"	=> 'XL',
                    "stock"	=> 55,
                    "title"	=> '朵绒菲小西装',
                    "price"	=> 175.88,
                    "number"	=> 1
                ],
                [
                    "id"	=> 5,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/jxrEvkBFmG1RNg39dOqUlAbt8H0Pzf5D.JPG',
                    "attr_val"	=> '520 #粉红色',
                    "stock"	=> 15,
                    "title"	=> '迪奥（Dior）烈艳唇膏',
                    "price"	=> 1089.00,
                    "number"	=> 1
                ],
                [
                    "id"	=> 6,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/8LejATRw2GMcsZfUXC1lEnI34t6pJxWb.jpg',
                    "attr_val"	=> '樱花味润手霜 30ml',
                    "stock"	=> 15,
                    "title"	=> "欧舒丹（L'OCCITANE）乳木果",
                    "price"	=> 128,
                    "number"	=> 1
                ],
                [
                    "id"	=> 7,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/T13e6Kql7gFVs0tPLS5kQ9xhmi8CYGbv.jpg',
                    "attr_val"	=> '特级 12个',
                    "stock"	=> 7,
                    "title"	=> '新疆阿克苏苹果 特级',
                    "price"	=> 58.8,
                    "number"	=> 10
                ],
                [
                    "id"	=> 8,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/4v8Et92Z1lg5SskwOCUuDjQ6IFycaLGe.jpg',
                    "attr_val"	=> '激光导航 扫拖一体',
                    "stock"	=> 15,
                    "title"	=> '科沃斯 Ecovacs 扫地机器人',
                    "price"	=> 1348.00,
                    "number"	=> 1
                ],
                [
                    "id"	=> 9,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/RN9m8DSn3g7zyAWp2J5OZvPjXfrucxBF.jpg',
                    "attr_val"	=> 'XL',
                    "stock"	=> 55,
                    "title"	=> '朵绒菲小西装',
                    "price"	=> 175.88,
                    "number"	=> 1
                ],
                [
                    "id"	=> 10,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/jxrEvkBFmG1RNg39dOqUlAbt8H0Pzf5D.JPG',
                    "attr_val"	=> '520 #粉红色',
                    "stock"	=> 15,
                    "title"	=> '迪奥（Dior）烈艳唇膏',
                    "price"	=> 1089.00,
                    "number"	=> 1
                ],
                [
                    "id"	=> 11,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/8LejATRw2GMcsZfUXC1lEnI34t6pJxWb.jpg',
                    "attr_val"	=> '樱花味润手霜 30ml',
                    "stock"	=> 15,
                    "title"	=> "欧舒丹（L'OCCITANE）乳木果",
                    "price"	=> 128,
                    "number"	=> 1
                ],
                [
                    "id"	=> 12,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/T13e6Kql7gFVs0tPLS5kQ9xhmi8CYGbv.jpg',
                    "attr_val"	=> '特级 12个',
                    "stock"	=> 7,
                    "title"	=> '新疆阿克苏苹果 特级',
                    "price"	=> 58.8,
                    "number"	=> 10
                ],
                [
                    "id"	=> 13,
                    "image"	=> 'https://api.thinkvue.cn/static/demo/img/dCKXDSFhkOVnzJrbfAepaHv2ENmtQloT.jpg',
                    "attr_val"	=> '春装款/m',
                    "stock"	=> 15,
                    "title"	=> '女装2019春秋新款',
                    "price"	=> 420.00,
                    "number"	=> 1
                ]
            ];
            //详情展示页面;
        }elseif($key=="detailData"){
            $data = [
                "title"	=> '纯种金毛幼犬活体有血统证书',
                "title2"	=> '拆家小能手 你值得拥有',
                "favorite"	=> true,
                "imgList"	=> [[
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg'
                    ],
                    [
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/vKtTOlZk7zVw60yHJugRFiD2XLsxdWqb.jpg'
                    ],
                    [
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/atFqXKwNxRA5QSuUlOzcVCsp0W927BMG.jpg'
                    ],
                    [
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/NCQDSvjdI3YreuTA6ElhxG8VaH7WF5Jz.jpg'
                    ],
                ],
                "episodeList"	=> [
                    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24
                ],
                "guessList"	=> [[
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/vhUuN5ZV4BKmnHjdaisqDoCpzyewRWbS.jpg',
                        "title"	=> '猫眼指甲油',
                        "title2"	=> '独树一帜的免照灯猫眼指甲'
                    ],
                    [
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg',
                        "title"	=> '创意屋',
                        "title2"	=> '创意屋形上下双层高低床'
                    ],
                    [
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/6RInGKbdJvpNQ14qUCr8t0zWsLM7ofgl.jpg',
                        "title"	=> 'MissCandy 指甲油',
                        "title2"	=> '十分适合喜欢素净的妹纸，尽显淡雅的气质'
                    ],
                    [
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg',
                        "title"	=> 'RMK 2017星空海蓝唇釉',
                        "title2"	=> '唇釉质地，上唇后很滋润。少女也会心动的蓝色，透明液体形状。'
                    ]
                ],
                "evaList"	=> [[
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/ri61QOavfSgd73mBDLTRPz5NA8be0EVX.jpg',
                        "nickname"	=> 'Ranth Allngal',
                        "time"	=> '09-20 "12"	=>54',
                        "zan"	=> '54',
                        "content"	=> '评论不要太苛刻，不管什么产品都会有瑕疵，客服也说了可以退货并且商家承担运费，我觉得至少态度就可以给五星。'
                    ],
                    [
                        "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg',
                        "nickname"	=> 'Ranth Allngal',
                        "time"	=> '09-20 "12"	=>54',
                        "zan"	=> '54',
                        "content"	=> '楼上说的好有道理。'
                    ]
                ]
            ];
        }elseif($key=="shareList"){
            $data = [[
                    "type"	=> 1,
                    "icon"	=> '/static/temp/share_wechat.png',
                    "text"	=> '微信好友'
                ],
                [
                    "type"	=> 2,
                    "icon"	=> '/static/temp/share_moment.png',
                    "text"	=> '朋友圈'
                ],
                [
                    "type"	=> 3,
                    "icon"	=> '/static/temp/share_qq.png',
                    "text"	=> 'QQ好友'
                ],
                [
                    "type"	=> 4,
                    "icon"	=> '/static/temp/share_qqzone.png',
                    "text"	=> 'QQ空间'
                ]
            ];
        }elseif($key=="lazyLoadList"){
            $data = [[
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/vKtTOlZk7zVw60yHJugRFiD2XLsxdWqb.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/atFqXKwNxRA5QSuUlOzcVCsp0W927BMG.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/NCQDSvjdI3YreuTA6ElhxG8VaH7WF5Jz.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/zwTJ8gfs1kplG4iXoIYCbuP0hqAUHNRv.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/0ht1fNb5CFDRXuMOlKQWiLVyBSzn264s.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/wNbMQVUmsjCp5Y7thPWogLr12RvBZy4c.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/cDiRt6qjKNd8mHh1ITLyeSuZBOPrXwkb.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/GwsafKqet8W9Mbv7omZT1nYyFUI52Lpd.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/ghBroZtFfuxdnyRLm1UDQbI8wYJ6k5sq.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/6RInGKbdJvpNQ14qUCr8t0zWsLM7ofgl.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/vhUuN5ZV4BKmnHjdaisqDoCpzyewRWbS.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/zSwh0WvM1x9rk6tjld4cJ7uABEeoG5Xg.jpeg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/notfound.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/KtvgZdXEkYhxecInC8Fisof5aHATR9r4.jpg'
                ],
                [
                    "src"	=> 'https://api.thinkvue.cn/static/demo/img/AR63vxCoK2yZ0G4aLkl1SVYs7NMW8uBQ.jpg'
                ],
            ];
        }elseif($key=="orderList"){
            $data = [[
                    "time"	=> '2019-04-06 "11"	=>37',
                    "state"	=> 1,
                    "goodsList"	=> [[
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/aCvBDOeNnKb3xcJQHEYtuZhIGPFUMWli.jpeg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/0Bry84GX9WMhbCajeYOvkoSJs2VqDHQN.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/XRO2w8uFnBbQ3UCg71koNJKEhzeqc6yt.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/0Bry84GX9WMhbCajeYOvkoSJs2VqDHQN.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/XRO2w8uFnBbQ3UCg71koNJKEhzeqc6yt.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/0Bry84GX9WMhbCajeYOvkoSJs2VqDHQN.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/XRO2w8uFnBbQ3UCg71koNJKEhzeqc6yt.jpg',
                        ]
                    ]
                ],
                [
                    "time"	=> '2019-04-06 "11"	=>37',
                    "state"	=> 9,
                    "goodsList"	=> [[
                        "title"	=> '古黛妃 短袖t恤女 春夏装2019新款韩版宽松',
                        "price"	=> 179.5,
                        "image"	=> 'https://api.thinkvue.cn/static/demo/img/qv1PETIyw5zYSdsp9MDRQZnHFUkOiAV6.jpg',
                        "number"	=> 1,
                        "attr"	=> '珊瑚粉 M'
                    ]]
                ],
                [
                    "time"	=> '2019-04-06 "11"	=>37',
                    "state"	=> 1,
                    "goodsList"	=> [[
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/J6Hs9gT53Zw1XNOSMRcQ2kfomUd8xWve.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/hoJdIkqaniBTuXCpe1m8yrtfQPs46Z37.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/I7PEL9U1GbgHVquyJdOfM83XjRcBp0iZ.jpg',
                        ],
                    ]
                ],
                [
                    "time"	=> '2019-04-06 "11"	=>37',
                    "state"	=> 1,
                    "goodsList"	=> [[
                        "title"	=> '回力女鞋高帮帆布鞋女学生韩版鞋子女2019潮鞋女鞋新款春季板鞋女',
                        "price"	=> 69,
                        "image"	=> 'https://api.thinkvue.cn/static/demo/img/szHRXN2iFKatE6mfvwhbSP5dWegk1JlY.jpg',
                        "number"	=> 1,
                        "attr"	=> '白色-高帮 39'
                    ]]
                ],
                [
                    "time"	=> '2019-04-06 "11"	=>37',
                    "state"	=> 1,
                    "goodsList"	=> [[
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/pthHaAJ81CkRyw7Mv3NSBLboY6g49QOU.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/6z9bqVdU1u4ktNai5ycIj7PRFDrlBGYm.jpg',
                        ],
                    ]
                ],
                [
                    "time"	=> '2019-04-06 "11"	=>37',
                    "state"	=> 1,
                    "goodsList"	=> [[
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/cY1ZrXnOg0VRt5KPLxJAWb9spjmf8kCE.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/qQ68ujM0ypCvOXU3RYxHWwSoVk5Pe9Tb.jpg',
                        ],
                        [
                            "image"	=> 'https://api.thinkvue.cn/static/demo/img/mvKCJXrWqHDLxIZ1Bf39j7nsVMNd2Q84.jpg',
                        ],
                    ]
                ]
            ];
        }elseif($key=="cateList"){
            $data = [[
                    "id"	=> 1,
                    "name"	=> '手机数码'
                ],
                [
                    "id"	=> 2,
                    "name"	=> '礼品鲜花'
                ],
                [
                    "id"	=> 3,
                    "name"	=> '男装女装'
                ],
                [
                    "id"	=> 4,
                    "name"	=> '母婴用品'
                ],
                [
                    "id"	=> 5,
                    "pid"	=> 1,
                    "name"	=> '手机通讯'
                ],
                [
                    "id"	=> 6,
                    "pid"	=> 1,
                    "name"	=> '运营商'
                ],
                [
                    "id"	=> 8,
                    "pid"	=> 5,
                    "name"	=> '全面屏手机',
                    "picture"	=> '/static/temp/cate2.jpg'
                ],
                [
                    "id"	=> 9,
                    "pid"	=> 5,
                    "name"	=> '游戏手机',
                    "picture"	=> '/static/temp/cate3.jpg'
                ],
                [
                    "id"	=> 10,
                    "pid"	=> 5,
                    "name"	=> '老人机',
                    "picture"	=> '/static/temp/cate1.jpg'
                ],
                [
                    "id"	=> 11,
                    "pid"	=> 5,
                    "name"	=> '拍照手机',
                    "picture"	=> '/static/temp/cate4.jpg'
                ],
                [
                    "id"	=> 12,
                    "pid"	=> 5,
                    "name"	=> '女性手机',
                    "picture"	=> '/static/temp/cate5.jpg'
                ],
                [
                    "id"	=> 14,
                    "pid"	=> 6,
                    "name"	=> '合约机',
                    "picture"	=> '/static/temp/cate1.jpg'
                ],
                [
                    "id"	=> 15,
                    "pid"	=> 6,
                    "name"	=> '选好卡',
                    "picture"	=> '/static/temp/cate4.jpg'
                ],
                [
                    "id"	=> 16,
                    "pid"	=> 6,
                    "name"	=> '办套餐',
                    "picture"	=> '/static/temp/cate5.jpg'
                ],
                [
                    "id"	=> 17,
                    "pid"	=> 2,
                    "name"	=> '礼品',
                ],
                [
                    "id"	=> 18,
                    "pid"	=> 2,
                    "name"	=> '鲜花',
                ],
                [
                    "id"	=> 19,
                    "pid"	=> 17,
                    "name"	=> '公益摆件',
                    "picture"	=> '/static/temp/cate7.jpg'
                ],
                [
                    "id"	=> 20,
                    "pid"	=> 17,
                    "name"	=> '创意礼品',
                    "picture"	=> '/static/temp/cate8.jpg'
                ],
                [
                    "id"	=> 21,
                    "pid"	=> 18,
                    "name"	=> '鲜花',
                    "picture"	=> '/static/temp/cate9.jpg'
                ],
                [
                    "id"	=> 22,
                    "pid"	=> 18,
                    "name"	=> '每周一花',
                    "picture"	=> '/static/temp/cate10.jpg'
                ],
                [
                    "id"	=> 23,
                    "pid"	=> 18,
                    "name"	=> '卡通花束',
                    "picture"	=> '/static/temp/cate11.jpg'
                ],
                [
                    "id"	=> 24,
                    "pid"	=> 18,
                    "name"	=> '永生花',
                    "picture"	=> '/static/temp/cate12.jpg'
                ],
                [
                    "id"	=> 25,
                    "pid"	=> 3,
                    "name"	=> '男装'
                ],
                [
                    "id"	=> 26,
                    "pid"	=> 3,
                    "name"	=> '女装'
                ],
                [
                    "id"	=> 27,
                    "pid"	=> 25,
                    "name"	=> '男士T恤',
                    "picture"	=> '/static/temp/cate13.jpg'
                ],
                [
                    "id"	=> 28,
                    "pid"	=> 25,
                    "name"	=> '男士外套',
                    "picture"	=> '/static/temp/cate14.jpg'
                ],
                [
                    "id"	=> 29,
                    "pid"	=> 26,
                    "name"	=> '裙装',
                    "picture"	=> '/static/temp/cate15.jpg'
                ],
                [
                    "id"	=> 30,
                    "pid"	=> 26,
                    "name"	=> 'T恤',
                    "picture"	=> '/static/temp/cate16.jpg'
                ],
                [
                    "id"	=> 31,
                    "pid"	=> 26,
                    "name"	=> '上装',
                    "picture"	=> '/static/temp/cate15.jpg'
                ],
                [
                    "id"	=> 32,
                    "pid"	=> 26,
                    "name"	=> '下装',
                    "picture"	=> '/static/temp/cate16.jpg'
                ],
                [
                    "id"	=> 33,
                    "pid"	=> 4,
                    "name"	=> '奶粉',
                ],
                [
                    "id"	=> 34,
                    "pid"	=> 4,
                    "name"	=> '营养辅食',
                ],
                [
                    "id"	=> 35,
                    "pid"	=> 4,
                    "name"	=> '童装',
                ],
                [
                    "id"	=> 39,
                    "pid"	=> 4,
                    "name"	=> '喂养用品',
                ],
                [
                    "id"	=> 36,
                    "pid"	=> 33,
                    "name"	=> '有机奶粉',
                    "picture"	=> '/static/temp/cate17.jpg'
                ],
                [
                    "id"	=> 37,
                    "pid"	=> 34,
                    "name"	=> '果泥/果汁',
                    "picture"	=> '/static/temp/cate18.jpg'
                ],
                [
                    "id"	=> 39,
                    "pid"	=> 34,
                    "name"	=> '面条/粥',
                    "picture"	=> '/static/temp/cate20.jpg'
                ],
                [
                    "id"	=> 42,
                    "pid"	=> 35,
                    "name"	=> '婴童衣橱',
                    "picture"	=> '/static/temp/cate19.jpg'
                ],
                [
                    "id"	=> 43,
                    "pid"	=> 39,
                    "name"	=> '吸奶器',
                    "picture"	=> '/static/temp/cate21.jpg'
                ],
                [
                    "id"	=> 44,
                    "pid"	=> 39,
                    "name"	=> '儿童餐具',
                    "picture"	=> '/static/temp/cate22.jpg'
                ],
                [
                    "id"	=> 45,
                    "pid"	=> 39,
                    "name"	=> '牙胶安抚',
                    "picture"	=> '/static/temp/cate23.jpg'
                ],
                [
                    "id"	=> 46,
                    "pid"	=> 39,
                    "name"	=> '围兜',
                    "picture"	=> '/static/temp/cate24.jpg'
                ],
            ];
        }else{
            $data = "No params";
        }
        return  resultArray(['data' =>$data]);
    }
}
 