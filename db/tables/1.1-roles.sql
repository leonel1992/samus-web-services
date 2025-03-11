-- ------------------
-- ROLES INICIALES --
-- ------------------
INSERT INTO `roles` (`id`, `name`, `description`) VALUES
('master', 'Avanzado', 'El usuario avanzado tiene todos los permisos del sistema, incluyendo aquellos que requiren permisos especiales.'),
('admin', 'Administrador', 'El administrador tiene acceso a casi todos los módulos del sistema, excepto aquellos que requiren permisos especiales.'),
('coord', 'Coordinador', 'El coordinador tiene acceso de tipo administrador pero sólo para sus registros y los de sus oficinas.'),
('agent', 'Agente', 'El agente u operador externo tiene acceso a las funcionalidades básicas del sistema, a sus registros y a los ajustes de sus clientes.'),
('office', 'Oficina', 'La oficina tiene acceso a las funcionalidades básicas del sistema, a sus registros y a los ajustes de sus clientes.'),
('client', 'Cliente', 'El cliente solo tiene acceso a las funcionalidade básicas del sistema y a los ajustes de su propio perfil.'),
('assist-1', 'Asistente 1', 'El sistente de nivel 1 es un colaborador con acceso a funcionalidades administrativas de nivel 1.'),
('assist-2', 'Asistente 2', 'El sistente de nivel 1 es un colaborador con acceso a funcionalidades administrativas de nivel 2.'),
('assist-3', 'Asistente 3', 'El sistente de nivel 1 es un colaborador con acceso a funcionalidades administrativas de nivel 3.'),
('assist-4', 'Asistente 4', 'El sistente de nivel 1 es un colaborador con acceso a funcionalidades administrativas de nivel 4.'),
('assist-5', 'Asistente 5', 'El sistente de nivel 1 es un colaborador con acceso a funcionalidades administrativas de nivel 5.');