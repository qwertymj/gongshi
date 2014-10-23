CREATE DATABASE gongshi DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use gongshi;

CREATE TABLE t_user(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL, #
    password VARCHAR(50) NOT NULL, # 
    sts int,        # 这个用户是否已经没取消，如果取消，不能登陆
    seq int,        # 用户排序顺序，暂时不需要考虑 
    role int     # 新建， 老板，用户的权限，1=>拥有，0=>没有
        # 上报，员工上报
         # 审核，确定员工上报的内容是否属实
         # 汇总，财务，能够查看项目和人，不能修改项目
);

CREATE TABLE t_project(
    id INT PRIMARY KEY AUTO_INCREMENT, # 这个是project_id
    project_code varchar(50), # 项目代码，用户输入
    project_name varchar(100), # 项目名称，用户输入
    sts int,  # status 项目的拥有者可以取消项目，1=>available
    pcontent varchar(200), # 项目备注
    startdate date, 
    enddate date,
    seq int     # 项目排序顺序，后台可以调整
); 


# 一个项目有哪些员工
CREATE TABLE t_project_user(
    id int PRIMARY KEY AUTO_INCREMENT, # row id
    project_id int, # reference `t_project`.`id`
    uid int, # reference `user`.`id`
    uname varchar(50),  # 用户姓名，`t_user`.`name`
    sts int, # 1=>有效，0=>无效
    seq int  # 排序
);

# 一个项目的单位，比如台
CREATE TABLE t_project_workunit(
    id int PRIMARY KEY AUTO_INCREMENT,  #unit id
    unitname varchar(40), # 单位名称，比如台
    sts int, # 
    price float,  # 单价
    seq int,
    workunit varchar(40),   # 名称，比如调研，管理员填写
    bh varchar(40) # 编号，管理员填写
);

CREATE TABLE t_work_log_project(
    work_log_id int PRIMARY KEY AUTO_INCREMENT,
    project_id int, # references `t_project`.`id` ok

    starttime date,
    endtime date,
    hourcount int, # 工作时长 ok
    logdate date, # 登记时间 
    uname varchar(50), # 报告人名字 ok
    userid int, # 报告人id ok
    projectsum int, # 数量 ok
    worklogproject varchar(200), # 备注 ok
    sts int, # 四个状态，上报，审核完成，退回，以结帐
    unitname varchar(50), # 单位 
    price float, # 单价 ok
    je float, # 金额 calcu
    shr varchar(50), # 审核人名字 ok
    shr_uid int, # 审核人id
    shdate date, # 审核日期
    shcontent varchar(100), # 审核意见
    notes varchar(100), # 历史审核意见 delete
    bh varchar(40), # 编号
    workunit varchar(40), # 对应t_project_workunit unitname
    workunitid int # 对应t_project_workunit id
);

insert into t_user (name,password,sts,seq,role) values ("admin",md5("admin"),0,0,0b1111);
    