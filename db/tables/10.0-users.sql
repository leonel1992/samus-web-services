-- ------------------
-- TIPOS DE CUENTA --
-- ------------------
INSERT INTO `user_accounts` (`id`, `name`) VALUES
('business', 'Negocio'),
('personal', 'Personal');


-- ----------
-- GENEROS --
-- ----------
INSERT INTO `user_genders` (`id`, `name`) VALUES
('F', 'Femenino'),
('M', 'Masculino'),
('O', 'Prefiero no decirlo');


-- ----------
-- ESTATUS --
-- ----------
INSERT INTO `user_status` (`id`, `name`) VALUES
('active', 'Activo'),
('blocked', 'Bloqueado');


-- ------------------
-- USUARIO INICIAL --
-- ------------------
INSERT INTO `users` (`rol`, `status`, `account`, `date_create`, `date_login`, `birthdate`, `nit`, `nit_number`, `nit_company`, `dni`, `dni_number`, `name`, `last_name`, `country`, `state`, `city`, `address`, `phone`, `email`, `password`, `balance_def`, `balance_tot`) VALUES
('advanced', 'active', 'personal', '2024-03-28 00:00:00', NULL, '1992-07-07 00:00:00', NULL, NULL, NULL, 0, 0, 'Leonel', 'Freites', 1, 0, 0, 'Calle 2B #36', 3242216385, 'leonel.freites.1@gmail.com', '$2y$10$7nGWSqFkOTzusNDXGkhJ7.Fp6PeK8juF3fse5hYqHTuWYr9dNfW76', NULL, NULL);