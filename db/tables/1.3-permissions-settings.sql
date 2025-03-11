-- TRIGGERS
DELIMITER $$

-- ACTIONS
CREATE TRIGGER before_update_actions
BEFORE UPDATE ON actions
FOR EACH ROW
BEGIN
    UPDATE permissions
    SET id = CONCAT(NEW.id, '|', module)
    WHERE action = OLD.id;
END$$

-- MODULES
CREATE TRIGGER before_update_modules
BEFORE UPDATE ON modules
FOR EACH ROW
BEGIN
    UPDATE permissions
    SET id = CONCAT(action, '|', NEW.id)
    WHERE module = OLD.id;
END$$

-- ROLES
CREATE TRIGGER before_update_roles
BEFORE UPDATE ON roles
FOR EACH ROW
BEGIN
    UPDATE permissions_roles
    SET id = CONCAT(NEW.id, '|', permission)
    WHERE rol = OLD.id;
END$$

-- PERMISSIONS
CREATE TRIGGER before_update_permissions
BEFORE UPDATE ON permissions
FOR EACH ROW
BEGIN
    UPDATE permissions_roles
    SET id = CONCAT(rol, '|', NEW.id)
    WHERE permission = OLD.id;
END$$

CREATE TRIGGER before_insert_permissions
BEFORE INSERT ON permissions
FOR EACH ROW
BEGIN
    SET NEW.id = CONCAT(NEW.action, '|', NEW.module);
END$$

CREATE TRIGGER after_insert_permissions
AFTER INSERT ON permissions
FOR EACH ROW
BEGIN
    SET @last_inserted_id = NEW.id;
END$$

-- PERMISSIONS ROLES
CREATE TRIGGER before_insert_permissions_roles
BEFORE INSERT ON permissions_roles
FOR EACH ROW
BEGIN
    SET NEW.id = CONCAT(NEW.rol, '|', NEW.permission);
END$$

CREATE TRIGGER after_insert_permissions_roles
AFTER INSERT ON permissions_roles
FOR EACH ROW
BEGIN
    SET @last_inserted_id = NEW.id;
END$$

DELIMITER ;


-- AJUSTES
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'admin', 'access|settings'),
(1, 'master', 'access|settings'),
(0, 'client', 'access|settings');


-- AJUSTES ACCIONES
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-actions'),
('insert', 'settings-actions'),
('delete', 'settings-actions'),
('update', 'settings-actions');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'admin', 'access|settings-actions'),
(1, 'admin', 'insert|settings-actions'),
(1, 'admin', 'delete|settings-actions'),
(1, 'admin', 'update|settings-actions'),

(0, 'master', 'access|settings-actions'),
(0, 'master', 'insert|settings-actions'),
(0, 'master', 'delete|settings-actions'),
(0, 'master', 'update|settings-actions'),

(0, 'client', 'access|settings-actions'),
(0, 'client', 'insert|settings-actions'),
(0, 'client', 'delete|settings-actions'),
(0, 'client', 'update|settings-actions');


-- AJUSTES MODULOS
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-modules'),
('insert', 'settings-modules'),
('delete', 'settings-modules'),
('update', 'settings-modules');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'admin', 'access|settings-modules'),
(1, 'admin', 'insert|settings-modules'),
(1, 'admin', 'delete|settings-modules'),
(1, 'admin', 'update|settings-modules'),

(0, 'master', 'access|settings-modules'),
(0, 'master', 'insert|settings-modules'),
(0, 'master', 'delete|settings-modules'),
(0, 'master', 'update|settings-modules'),

(0, 'client', 'access|settings-modules'),
(0, 'client', 'insert|settings-modules'),
(0, 'client', 'delete|settings-modules'),
(0, 'client', 'update|settings-modules');


-- AJUSTES PERMISOS
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-permissions'),
('insert', 'settings-permissions'),
('delete', 'settings-permissions'),
('update', 'settings-permissions');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'admin', 'access|settings-permissions'),
(1, 'admin', 'insert|settings-permissions'),
(1, 'admin', 'delete|settings-permissions'),
(1, 'admin', 'update|settings-permissions'),

(1, 'master', 'access|settings-permissions'),
(1, 'master', 'insert|settings-permissions'),
(1, 'master', 'delete|settings-permissions'),
(1, 'master', 'update|settings-permissions'),

(0, 'client', 'access|settings-permissions'),
(0, 'client', 'insert|settings-permissions'),
(0, 'client', 'delete|settings-permissions'),
(0, 'client', 'update|settings-permissions');


-- AJUSTES ROLES
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'settings-roles'),
('insert', 'settings-roles'),
('delete', 'settings-roles'),
('update', 'settings-roles');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'admin', 'access|settings-roles'),
(1, 'admin', 'insert|settings-roles'),
(1, 'admin', 'delete|settings-roles'),
(1, 'admin', 'update|settings-roles'),

(1, 'master', 'access|settings-roles'),
(1, 'master', 'insert|settings-roles'),
(1, 'master', 'delete|settings-roles'),
(1, 'master', 'update|settings-roles'),

(0, 'client', 'access|settings-roles'),
(0, 'client', 'insert|settings-roles'),
(0, 'client', 'delete|settings-roles'),
(0, 'client', 'update|settings-roles');