-- AJUSTES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings');

-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('admin---access--settings', 1, 'admin', 'access--settings'),
-- ('advanced---access--settings', 1, 'advanced', 'access--settings'),
-- ('client---access--settings', 0, 'client', 'access--settings');


-- AJUSTES MONEDAS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-currencies'),
('insert', 'settings-currencies'),
('delete', 'settings-currencies'),
('update', 'settings-currencies');

-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('advanced---access--settings-currencies', 1, 'advanced', 'access--settings-currencies'),
-- ('advanced---insert--settings-currencies', 1, 'advanced', 'insert--settings-currencies'),
-- ('advanced---delete--settings-currencies', 1, 'advanced', 'delete--settings-currencies'),
-- ('advanced---update--settings-currencies', 1, 'advanced', 'update--settings-currencies');


-- AJUSTES PAISES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-countries'),
('insert', 'settings-countries'),
('delete', 'settings-countries'),
('update', 'settings-countries');

-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('advanced---access--settings-countries', 1, 'advanced', 'access--settings-countries'),
-- ('advanced---insert--settings-countries', 1, 'advanced', 'insert--settings-countries'),
-- ('advanced---delete--settings-countries', 1, 'advanced', 'delete--settings-countries'),
-- ('advanced---update--settings-countries', 1, 'advanced', 'update--settings-countries');


-- AJUSTES PROCESADORES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-processors'),
('insert', 'settings-processors'),
('delete', 'settings-processors'),
('update', 'settings-processors');

-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('advanced---access--settings-processors', 1, 'advanced', 'access--settings-processors'),
-- ('advanced---insert--settings-processors', 1, 'advanced', 'insert--settings-processors'),
-- ('advanced---delete--settings-processors', 1, 'advanced', 'delete--settings-processors'),
-- ('advanced---update--settings-processors', 1, 'advanced', 'update--settings-processors');


-- AJUSTES METODOS DE PAGO 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-payment-methods'),
('insert', 'settings-payment-methods'),
('delete', 'settings-payment-methods'),
('update', 'settings-payment-methods');

-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('advanced---access--settings-payment-methods', 1, 'advanced', 'access--settings-payment-methods'),
-- ('advanced---insert--settings-payment-methods', 1, 'advanced', 'insert--settings-payment-methods'),
-- ('advanced---delete--settings-payment-methods', 1, 'advanced', 'delete--settings-payment-methods'),
-- ('advanced---update--settings-payment-methods', 1, 'advanced', 'update--settings-payment-methods');


-- AJUSTES ACCIONES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-actions'),
('insert', 'settings-actions'),
('delete', 'settings-actions'),
('update', 'settings-actions');

-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('admin---access--settings-actions', 1, 'admin', 'access--settings-actions'),
-- ('admin---insert--settings-actions', 1, 'admin', 'insert--settings-actions'),
-- ('admin---delete--settings-actions', 1, 'admin', 'delete--settings-actions'),
-- ('admin---update--settings-actions', 1, 'admin', 'update--settings-actions'),
-- ('advanced---access--settings-actions', 1, 'advanced', 'access--settings-actions'),
-- ('advanced---insert--settings-actions', 1, 'advanced', 'insert--settings-actions'),
-- ('advanced---delete--settings-actions', 1, 'advanced', 'delete--settings-actions'),
-- ('advanced---update--settings-actions', 1, 'advanced', 'update--settings-actions'),
-- ('client---access--settings-actions', 0, 'client', 'access--settings-actions'),
-- ('client---insert--settings-actions', 0, 'client', 'insert--settings-actions'),
-- ('client---delete--settings-actions', 0, 'client', 'delete--settings-actions'),
-- ('client---update--settings-actions', 0, 'client', 'update--settings-actions');


-- AJUSTES MODULOS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-modules'),
('insert', 'settings-modules'),
('delete', 'settings-modules'),
('update', 'settings-modules');


-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('admin---access--settings-modules', 1, 'admin', 'access--settings-modules'),
-- ('admin---insert--settings-modules', 1, 'admin', 'insert--settings-modules'),
-- ('admin---delete--settings-modules', 1, 'admin', 'delete--settings-modules'),
-- ('admin---update--settings-modules', 1, 'admin', 'update--settings-modules'),
-- ('advanced---access--settings-modules', 1, 'advanced', 'access--settings-modules'),
-- ('advanced---insert--settings-modules', 1, 'advanced', 'insert--settings-modules'),
-- ('advanced---delete--settings-modules', 1, 'advanced', 'delete--settings-modules'),
-- ('advanced---update--settings-modules', 1, 'advanced', 'update--settings-modules'),
-- ('client---access--settings-modules', 0, 'client', 'access--settings-modules'),
-- ('client---insert--settings-modules', 0, 'client', 'insert--settings-modules'),
-- ('client---delete--settings-modules', 0, 'client', 'delete--settings-modules'),
-- ('client---update--settings-modules', 0, 'client', 'update--settings-modules');


-- AJUSTES PERMISOS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-permissions'),
('insert', 'settings-permissions'),
('delete', 'settings-permissions'),
('update', 'settings-permissions');


-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('admin---access--settings-permissions', 1, 'admin', 'access--settings-permissions'),
-- ('admin---insert--settings-permissions', 1, 'admin', 'insert--settings-permissions'),
-- ('admin---delete--settings-permissions', 1, 'admin', 'delete--settings-permissions'),
-- ('admin---update--settings-permissions', 1, 'admin', 'update--settings-permissions'),
-- ('advanced---access--settings-permissions', 1, 'advanced', 'access--settings-permissions'),
-- ('advanced---insert--settings-permissions', 1, 'advanced', 'insert--settings-permissions'),
-- ('advanced---delete--settings-permissions', 1, 'advanced', 'delete--settings-permissions'),
-- ('advanced---update--settings-permissions', 1, 'advanced', 'update--settings-permissions'),
-- ('client---access--settings-permissions', 0, 'client', 'access--settings-permissions'),
-- ('client---insert--settings-permissions', 0, 'client', 'insert--settings-permissions'),
-- ('client---delete--settings-permissions', 0, 'client', 'delete--settings-permissions'),
-- ('client---update--settings-permissions', 0, 'client', 'update--settings-permissions');


-- AJUSTES ROLES 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-roles'),
('insert', 'settings-roles'),
('delete', 'settings-roles'),
('update', 'settings-roles');

-- INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
-- ('admin---access--settings-roles', 1, 'admin', 'access--settings-roles'),
-- ('admin---insert--settings-roles', 1, 'admin', 'insert--settings-roles'),
-- ('admin---delete--settings-roles', 1, 'admin', 'delete--settings-roles'),
-- ('admin---update--settings-roles', 1, 'admin', 'update--settings-roles'),
-- ('advanced---access--settings-roles', 1, 'advanced', 'access--settings-roles'),
-- ('advanced---insert--settings-roles', 1, 'advanced', 'insert--settings-roles'),
-- ('advanced---delete--settings-roles', 1, 'advanced', 'delete--settings-roles'),
-- ('advanced---update--settings-roles', 1, 'advanced', 'update--settings-roles'),
-- ('client---access--settings-roles', 0, 'client', 'access--settings-roles'),
-- ('client---insert--settings-roles', 0, 'client', 'insert--settings-roles'),
-- ('client---delete--settings-roles', 0, 'client', 'delete--settings-roles'),
-- ('client---update--settings-roles', 0, 'client', 'update--settings-roles');