# 织梦CMS转Joomla!

简单建立了一个组件，用织梦的数据库中读取数据后，通过com_content组件的model（article,category)存入joomla中

存入之后可以导入到K2中

存在一个问题：因为*com_content*的item还需要在** #__asset** 中写入，导致保存时会报错“parent id 无效”。

解决办法是重新rebuild 目录