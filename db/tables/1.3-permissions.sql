
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
