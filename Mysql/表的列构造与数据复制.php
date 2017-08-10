维护数据库时，遇到大量的数据输入的情况，非常耗费时间，一次创建的数据如何再次利用，就必须知道如何复制表以及数据

✪   表的构造+数据的复制
✪   表的构造复制
✪   数据的复制

1 表的构造+数据的复制
从检索出来的结果中复制列构造与记录，并创建新表，简单高效

CREATE TABLE 表名 SELECT * FROM 要复制的表

使用此方法可能发生列属性改变的情况 VARCHAR(20) 可能修改为CHAR(20) 在复制完成后使用 DESC 表名 来确认一下表的构造

2 复制表的构造
此方法只复制表的结构来创建新表，但 AUTO_INCREMENT PRIMARY KEY 等列构造会被复制

CREATE TABLE 表名 LIKE 要复制的表

3 数据的复制
其实这个是基于上面第2步，简单粗暴的来说就是向已经存在的表中插入数据

INSER INTO 表名 SELECT * FROM 要复制的表

可以加入WHERE 或LIMIT 等限制语句来限制抽出的记录，而且以这种方法从其他表结构不一样的表中复制数据

INSERT INTO user('name') SELECT goods_name FROM goods