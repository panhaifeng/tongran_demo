安装:
1,将本目录下所有文件，拷贝到"项目根目录\Tool\DbAutoUpgrade\"目录下,
2,修改config.php文件中的数据库名
3,在"项目根目录\Tool\"下建立一个index.php文件，建立一个指向"项目根目录/Tool/DbAutoUpgrade/index.php"的链接。
4,执行"项目根目录/Tool/index.php"文件,自动建立sql_log表和清空修改日志文件，安装完成

程序员输入数据库修改记录：
1,打开/Tool/DbAutoUpgrade/index.php文件,在文本框中输入需要保存的sql语句，多个sql语句可用';'分隔，
2，点击提交，会自动将sql语句保存到log.ini文件中。
3, 通过svn进行commit,如果commit时需要update,则先update再commit,如果update时发生冲突，说明有别的程序员与你同时修改了数据库结构，这时要特别小心如下操作
	a,编辑冲突
	b,冲突块一般都发生在最后，找到冲突块(2行以上)
	c,冲突块的第一行右键，选择use mine;
	d,冲突块的余下块，统一选择user mine before theirs
	e,保存，标记为解决，这样就将别人的修改合并过来了。
	f,在本机上执行下"确定执行",确保别人的改动在本机数据库中生效。
或者直接人工进行编辑。

自动更新本地数据库
1,打开/Tool/DbAutoUpgrade/index.php文件,点击确认更新即可。