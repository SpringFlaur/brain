### 登录接口

* 访问方式

post

* 参数

email:用户邮箱
password：密码

* 返回值


{
    
    "code":-1,
    "msg":"用户不存在",
    "data":[

    ]
}

{
    
    "code":0,
    "msg":"登录成功",
    "data":[
        "token":"5dsys7fhfh43tbb34"
    ]
}