INSERT IGNORE INTO `roles` (`id`, `name`, `description`) VALUES
('master', 'Avanzado', 'El usuario avanzado tiene todos los permisos del sistema, incluyendo aquellos que requiren permisos especiales.'),
('admin', 'Administrador', 'El administrador tiene acceso a casi todos los módulos del sistema, excepto aquellos que requiren permisos especiales.'),
('client', 'Cliente', 'El cliente solo tiene acceso a las funcionalidade básicas del sistema y a los ajustes de su propio perfil.');