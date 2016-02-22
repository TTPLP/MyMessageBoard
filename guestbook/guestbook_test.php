<html>
<head>
    <title>留言板</title>
</head>
<body>
    <p>
        您好：abc <br />
        歡迎使用！ <a href="index.html">登出</a> <br/>
        <a href="member_manage.html">帳號管理</a>
        <hr />
    </p>

    <p>
        <p align="center"><label >留言列表</label></p>

        <form>
            <li>
                <input type="checkbox"/>
                <label>
                    主題：<a href="message_page.html">主題1</a>
                    留言人：abc
                    信箱：abc@haha.com
                </label>
            </li>
            <li>
                <input type="checkbox"/>
                <label>
                    主題：<a href="">主題2</a>
                    留言人：acd
                    信箱：acd@kuku.com
                </label>
            </li>
            <input type="submit" value="刪除" />
        </form>

        <hr />
    </p>

    <p>
        <p align="center"><label>新增留言</label></p>
        <form>
            留言主題：<input type="text" name="title" size="20" /> <br />
            留言內容：<br />
            <textarea name="content" cols="60" rows="30"></textarea> <br />
            <input type="submit" value="送出" />
        </form>
    </p>
</body>
</html>