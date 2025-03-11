-- ------------
-- REGISTROS --
-- ------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('records', 'Registros', '', '');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--records', 'access', 'records');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--records', 1, 'admin', 'access--records'),
('advanced---access--records', 1, 'advanced', 'access--records'),
('client---access--records', 0, 'client', 'access--records');