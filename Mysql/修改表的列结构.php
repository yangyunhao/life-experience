表创建好后想扩大列的长度，追加新列，删除列，以及改变列的，名称，或是想要改变列的排序，这时候必须使用 ALTER TABLE 命令来完成

ALTER TABLE 是修改表的列构造的，根据修改的种类有 MODIFY,CHANGE,ADD,DROP等几种语法

✪ 修改列的定义             ALTER TABLE ...... MODIFY
✪ 追加列			      ALTER TABLE.......ADD
✪ 修改列的名称与定义   ALTER TABLE.......CHANGE
✪ 删除列			      ALTER TABLE.......DROP

1 列的数据类型是可以随时更改的，例如将VARCHAR数据类型的列修改为可以容纳更多数据的text类型，修改过程中可能出现原来的数据乱码或是
一部分数据消失，例如，一个原来可以容纳100个汉字的列改为VARCHAR（50）50 以后的数据就会消失，所以在修改前一定要备份数据表。

修改·name· 列的数据类型
ALTER TABLE ·customer· MODIFY  ·name· VARCHAR (20)；
修改完成后可用DESC customer 来查看数据结构

2 追加新列，在追加的时候默认追加到表的最后，可以用FIRST,AFTER来决定插入到哪里
追加年龄列的SQL
ALTER TABLE customer ADD old INT（2）  会在表的结尾追加列
ALTER TABLE customer ADD old INT（2） FIRST 这样就会在表的头部也就是第一列追加
ALTER TABLE customer ADD old INT（2） AFTER `name` 在任意位置追加新列

3 改变列的位置就可以使用MODIFY关键字
将已经存在customer表中old移动到姓名name之后最后显示修改的表结构
ALTER TABLE customer MODIFY old INT(2) AFTER `name`
要带上长度，不带也不会报错，但是会给你改变列的长度为默认值

4 修改列名与类型
将年龄old列数据类型改为VARCHAR并将列名改为CITY语法如下
ALTER TABLE customer CHANGE old city VARCHAR(32)

5 删除列 使用关键字 DROP
ALTER TABLE  customer DROP old
