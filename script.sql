create table rick_configs
(
    k varchar(255) default '' not null
        primary key,
    v text                    null
);

INSERT INTO rick_configs (k, v) VALUES ('website', 'EasyAdmin');
INSERT INTO rick_configs (k, v) VALUES ('title', '');
INSERT INTO rick_configs (k, v) VALUES ('keywords', '');
INSERT INTO rick_configs (k, v) VALUES ('description', '');

create table rick_system_account
(
    id         int auto_increment
        primary key,
    username   varchar(12)      not null comment '用户名',
    password   varchar(32)      not null comment '密码',
    salting    varchar(32)      not null comment '密码盐',
    email      varchar(32)      not null comment '邮箱地址',
    loginTime  datetime         null comment '登录时间',
    createTime datetime         not null comment '创建时间',
    tenantId   int(2)           null comment '上级ID',
    status     int(2) default 0 not null comment '状态'
);

INSERT INTO rick_system_account (id, username, password, salting, email, loginTime, createTime, tenantId, status) VALUES (1, 'admin', 'e35279f6ca6dd3436b3966e8f40f09dd', '659204b6ca9984eeeb591f3d157c765a', '2687409344@qq.com', '2022-11-13 19:58:32', '2022-01-12 18:26:26', 0, 1);

create table rick_system_account_role
(
    userId     int      null comment '管理员ID',
    roleId     int      null comment '权限ID',
    createTime datetime not null comment '创建时间'
);

INSERT INTO rick_system_account_role (userId, roleId, createTime) VALUES (1, 1, '2022-01-12 18:26:26');

create table rick_system_login_log
(
    id         int auto_increment
        primary key,
    username   varchar(255) null comment '用户名',
    userId     int          null comment '用户ID',
    ip         varchar(255) null comment 'IP地址',
    browser    varchar(255) null comment '浏览器',
    osName     varchar(255) null comment '系统名称',
    city       varchar(255) null comment '城市',
    createTime datetime     null comment '登录时间'
);

create table rick_system_plugins
(
    id         int auto_increment comment 'ID'
        primary key,
    fileName   varchar(25)   null comment '插件文件名',
    name       varchar(25)   not null comment '插件名称',
    status     int default 0 null comment '1开启 0关闭',
    data       json          null comment '配置项',
    createTime datetime      not null comment '创建时间',
    updateTime datetime      null comment '更新时间',
    constraint ricky_system_pay_id_uindex
        unique (id)
);

create table rick_system_role
(
    roleId     int auto_increment
        primary key,
    comments   varchar(255) null comment '角色备注',
    createTime datetime     not null comment '创建时间',
    deleted    int(2)       null comment '删除',
    roleCode   varchar(32)  null comment '角色标识',
    roleName   varchar(32)  null comment '角色名称',
    userId     int(2)       null comment '创建者ID',
    updateTime datetime     null comment '更新时间'
);

INSERT INTO rick_system_role (roleId, comments, createTime, deleted, roleCode, roleName, userId, updateTime) VALUES (1, '系统管理员', '2022-01-12 18:26:26', 0, 'admin', '管理员', 1, '2022-01-15 22:34:19');

create table rick_system_role_routers
(
    roleId     int           null comment '角色ID',
    menuId     int           null comment '权限ID',
    sort       int default 0 not null comment '排序',
    createTime datetime      not null comment '创建时间'
);

INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 125, 125, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 119, 119, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 118, 118, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 117, 117, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 116, 116, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 115, 115, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 114, 114, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 124, 124, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 123, 123, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 122, 122, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 121, 121, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 120, 120, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 41, 41, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 40, 40, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 11, 11, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 42, 42, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 39, 39, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 38, 38, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 37, 37, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 34, 34, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 33, 33, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 32, 32, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 30, 30, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 28, 28, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 9, 9, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 21, 21, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 20, 20, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 19, 19, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 18, 18, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 8, 8, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 23, 23, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 22, 22, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 15, 15, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 14, 14, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 13, 13, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 12, 12, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 7, 7, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 25, 25, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 24, 24, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 6, 6, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 5, 5, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 2, 2, '2022-11-13 22:59:06');
INSERT INTO rick_system_role_routers (roleId, menuId, sort, createTime) VALUES (1, 1, 1, '2022-11-13 22:59:06');

create table rick_system_router
(
    menuId     int auto_increment
        primary key,
    title      varchar(32)      null comment '菜单名称',
    parentId   int              null comment '上级菜单ID',
    hide       int(2) default 0 not null comment '隐藏',
    icon       varchar(32)      null comment '图标',
    type       int(2) default 0 not null comment '权限类型',
    authority  varchar(255)     null comment '权限标识',
    path       varchar(255)     null comment '地址',
    tenantId   int(2)           null comment '创建人ID',
    updateTime datetime         null comment '更新时间',
    createTime datetime         not null comment '创建时间'
);

INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (1, '控制面板', 0, 0, 'layui-icon-home', 0, '', '', 1, '2022-01-15 20:01:06', '2022-01-13 00:12:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (2, '工作台', 1, 0, 'layui-icon-find-fill', 0, '', '/', 1, '2022-03-24 14:24:33', '2022-01-13 00:12:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (5, '系统管理', 0, 0, 'layui-icon-set', 0, null, '', 1, null, '2022-01-13 00:12:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (6, '网站信息', 5, 0, 'layui-icon-form', 0, null, '/system/webset', 1, null, '2022-01-13 00:12:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (7, '角色管理', 5, 0, 'layui-icon-user', 0, null, '/system/role', 1, null, '2022-01-13 00:12:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (8, '菜单权限', 5, 0, 'layui-icon-auz', 0, '', '/system/menu', 1, '2022-11-12 20:46:09', '2022-01-13 00:12:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (9, '用户管理', 5, 0, 'layui-icon-username', 0, '', '/system/user', 1, '2022-11-12 20:46:19', '2022-01-13 00:12:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (11, '登录日志', 5, 0, 'layui-icon-survey', 0, '', '/system/login-record', null, null, '2022-01-15 01:09:14');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (12, '分页列表', 7, 0, '', 1, '/system/role/pageRoles', '', null, '2022-10-29 21:11:11', '2022-01-15 11:54:37');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (13, '增加数据', 7, 0, '', 1, '/system/role/add', '', null, '2022-10-29 21:11:16', '2022-01-15 11:55:11');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (14, '修改数据', 7, 0, '', 1, '/system/role/edit', '', null, '2022-10-29 21:11:20', '2022-01-15 11:55:43');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (15, '删除角色', 7, 0, '', 1, '/system/role/del', '', null, '2022-10-29 21:11:25', '2022-01-15 11:56:17');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (18, '全部列表', 8, 0, '', 1, '/system/router/menuList', '', null, '2022-10-29 21:13:03', '2022-01-15 11:54:37');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (19, '增加数据', 8, 0, '', 1, '/system/router/add', '', null, '2022-10-29 21:13:11', '2022-01-15 11:55:11');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (20, '删除数据', 8, 0, '', 1, '/system/router/del', '', null, '2022-10-29 21:13:16', '2022-01-15 11:56:17');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (21, '修改数据', 8, 0, '', 1, '/system/router/edit', '', null, '2022-10-29 21:13:20', '2022-01-15 11:55:43');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (22, '查询权限	', 7, 0, '', 1, '/system/roleRouters/listRouters', '', null, '2022-10-29 21:11:28', '2022-01-15 11:54:37');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (23, '分配权限	', 7, 0, '', 1, '/system/roleRouters/updateRoleMenus', '', null, '2022-10-29 21:11:31', '2022-01-15 11:54:37');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (24, '获取配置', 6, 0, '', 1, '/system/getConfigs', '', null, '2022-10-29 21:10:56', '2022-01-15 22:54:52');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (25, '修改配置', 6, 0, '', 1, '/system/editConfigs', '', null, '2022-10-29 21:11:00', '2022-01-15 22:56:10');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (28, '分页列表', 9, 0, '', 1, '/system/account/page', '', null, '2022-10-29 21:11:38', '2022-01-16 18:01:27');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (30, '角色列表', 9, 0, '', 1, '/system/role/getList', '', null, '2022-10-29 21:11:43', '2022-01-16 20:08:41');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (32, '字段查重', 9, 0, '', 1, '/system/account/existence', '', null, '2022-10-29 21:11:49', '2022-01-18 18:21:17');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (33, '增加数据', 9, 0, '', 1, '/system/account/add', '', null, '2022-10-29 21:11:55', '2022-01-18 18:26:28');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (34, '修改数据', 9, 0, '', 1, '/system/account/edit', '', null, '2022-10-29 21:12:06', '2022-01-19 00:13:17');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (37, '重置密码', 9, 0, '', 1, '/system/account/password', '', null, '2022-10-29 21:12:00', '2022-01-19 00:56:33');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (38, '删除数据', 9, 0, '', 1, '/system/account/del', '', null, '2022-10-29 21:12:11', '2022-01-19 01:18:21');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (39, '批量删除', 9, 0, '', 1, '/system/account/batch', '', null, '2022-10-29 21:12:15', '2022-01-19 01:37:29');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (40, '分页列表', 11, 0, '', 1, '/system/loginLog/page', '', null, '2022-10-29 21:12:27', '2022-01-19 02:39:46');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (41, '全部列表', 11, 0, '', 1, '/system/loginLog/getList', '', null, '2022-10-29 21:12:30', '2022-01-19 02:45:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (42, '更改状态', 9, 0, '', 1, '/system/account/status', '', null, '2022-10-29 21:12:18', '2022-01-19 17:05:34');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (115, '插件列表', 114, 0, 'layui-icon-util', 0, '', '/plugin/list', null, '2022-11-12 21:43:43', '2022-11-12 21:41:51');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (116, '全部列表', 115, 0, '', 1, '/system/plugins/list', '', null, null, '2022-11-12 21:50:40');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (117, '更改状态', 115, 0, '', 1, '/system/plugins/status', '', null, null, '2022-11-12 21:51:14');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (118, '获取输入框', 115, 0, '', 1, '/system/plugins/getInputList', '', null, null, '2022-11-12 21:52:02');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (119, '编辑配置', 115, 0, '', 1, '/system/plugins/editData', '', null, null, '2022-11-12 21:52:45');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (120, '应用管理', 0, 0, 'layui-icon-app', 0, '', '', null, null, '2022-11-13 22:45:48');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (121, '订单管理', 120, 0, 'layui-icon-rmb', 0, '', '/user/order', null, null, '2022-11-13 22:47:06');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (122, '分页列表', 121, 0, '', 1, '/system/order/page', '', null, null, '2022-11-13 22:57:39');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (123, '修改数据', 121, 0, '', 1, '/system/order/edit', '', null, null, '2022-11-13 22:58:06');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (124, '删除数据', 121, 0, '', 1, '/system/order/del', '', null, null, '2022-11-13 22:58:36');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (125, '批量删除', 121, 0, '', 1, '/system/order/batch', '', null, null, '2022-11-13 22:58:59');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (106, '我的插件', 105, 0, 'layui-icon-component', 0, '', '/plugin/list', null, '2022-10-24 16:22:24', '2022-10-24 13:46:50');
INSERT INTO rick_system_router (menuId, title, parentId, hide, icon, type, authority, path, tenantId, updateTime, createTime) VALUES (114, '插件管理', 0, 0, 'layui-icon-code-circle', 0, '', '', null, null, '2022-11-12 21:39:13');

create table rick_user_order
(
    id         varchar(255)  not null comment '订单号',
    trade_no   varchar(255)  null comment '交易号',
    money      decimal       null comment '交易金额',
    name       varchar(25)   null comment '订单名称',
    type       varchar(25)   null,
    plugin     varchar(25)   null,
    createTime datetime      null,
    updateTime datetime      null,
    code       varchar(25)   null,
    status     int default 0 null,
    constraint rick_user_order_id_uindex
        unique (id)
);