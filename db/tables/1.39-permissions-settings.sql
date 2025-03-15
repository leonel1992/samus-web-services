-- AJUSTES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings'),
(1, 'admin', 'access|settings'),
(0, 'coord', 'access|settings'),
(0, 'agent', 'access|settings'),
(0, 'office', 'access|settings'),
(0, 'client', 'access|settings'),
(0, 'assist-1', 'access|settings'),
(0, 'assist-2', 'access|settings'),
(0, 'assist-3', 'access|settings'),
(0, 'assist-4', 'access|settings'),
(0, 'assist-5', 'access|settings');


-- AJUSTES MONEDAS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-currencies'),
('insert', 'settings-currencies'),
('delete', 'settings-currencies'),
('update', 'settings-currencies');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings-currencies'),
(1, 'master', 'insert|settings-currencies'),
(1, 'master', 'delete|settings-currencies'),
(1, 'master', 'update|settings-currencies'),

(1, 'admin', 'access|settings-currencies'),
(1, 'admin', 'insert|settings-currencies'),
(1, 'admin', 'delete|settings-currencies'),
(1, 'admin', 'update|settings-currencies');


-- AJUSTES PAISES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-countries'),
('insert', 'settings-countries'),
('delete', 'settings-countries'),
('update', 'settings-countries');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings-countries'),
(1, 'master', 'insert|settings-countries'),
(1, 'master', 'delete|settings-countries'),
(1, 'master', 'update|settings-countries'),

(1, 'admin', 'access|settings-countries'),
(1, 'admin', 'insert|settings-countries'),
(1, 'admin', 'delete|settings-countries'),
(1, 'admin', 'update|settings-countries');


-- AJUSTES PROCESADORES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-processors'),
('insert', 'settings-processors'),
('delete', 'settings-processors'),
('update', 'settings-processors');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings-processors'),
(1, 'master', 'insert|settings-processors'),
(1, 'master', 'delete|settings-processors'),
(1, 'master', 'update|settings-processors'),

(1, 'admin', 'access|settings-processors'),
(1, 'admin', 'insert|settings-processors'),
(1, 'admin', 'delete|settings-processors'),
(1, 'admin', 'update|settings-processors');


-- AJUSTES METODOS DE PAGO 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-payment-methods'),
('insert', 'settings-payment-methods'),
('delete', 'settings-payment-methods'),
('update', 'settings-payment-methods');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings-payment-methods'),
(1, 'master', 'insert|settings-payment-methods'),
(1, 'master', 'delete|settings-payment-methods'),
(1, 'master', 'update|settings-payment-methods'),

(1, 'admin', 'access|settings-payment-methods'),
(1, 'admin', 'insert|settings-payment-methods'),
(1, 'admin', 'delete|settings-payment-methods'),
(1, 'admin', 'update|settings-payment-methods');


-- AJUSTES ACCIONES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-actions'),
('insert', 'settings-actions'),
('delete', 'settings-actions'),
('update', 'settings-actions');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings-actions'),
(1, 'master', 'insert|settings-actions'),
(1, 'master', 'delete|settings-actions'),
(1, 'master', 'update|settings-actions'),

(1, 'admin', 'access|settings-actions'),
(0, 'admin', 'insert|settings-actions'),
(0, 'admin', 'delete|settings-actions'),
(0, 'admin', 'update|settings-actions');


-- AJUSTES MODULOS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-modules'),
('insert', 'settings-modules'),
('delete', 'settings-modules'),
('update', 'settings-modules');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings-modules'),
(1, 'master', 'insert|settings-modules'),
(1, 'master', 'delete|settings-modules'),
(1, 'master', 'update|settings-modules'),

(1, 'admin', 'access|settings-modules'),
(0, 'admin', 'insert|settings-modules'),
(0, 'admin', 'delete|settings-modules'),
(0, 'admin', 'update|settings-modules');


-- AJUSTES PERMISOS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-permissions'),
('insert', 'settings-permissions'),
('delete', 'settings-permissions'),
('update', 'settings-permissions');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings-permissions'),
(1, 'master', 'insert|settings-permissions'),
(1, 'master', 'delete|settings-permissions'),
(1, 'master', 'update|settings-permissions'),

(1, 'admin', 'access|settings-permissions'),
(1, 'admin', 'insert|settings-permissions'),
(1, 'admin', 'delete|settings-permissions'),
(1, 'admin', 'update|settings-permissions');


-- AJUSTES ROLES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-roles'),
('insert', 'settings-roles'),
('delete', 'settings-roles'),
('update', 'settings-roles');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|settings-roles'),
(1, 'master', 'insert|settings-roles'),
(1, 'master', 'delete|settings-roles'),
(1, 'master', 'update|settings-roles'),

(1, 'admin', 'access|settings-roles'),
(1, 'admin', 'insert|settings-roles'),
(1, 'admin', 'delete|settings-roles'),
(1, 'admin', 'update|settings-roles');