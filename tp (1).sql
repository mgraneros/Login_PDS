SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

SET time_zone = "+00:00";

--
-- Base de datos: login
--

-- --------------------------------------------------------

CREATE DATABASE login;

USE login;


--
-- Estructura de tabla para la tabla logs
--

CREATE TABLE logs (
  id_log int(11) NOT NULL,
  fecha timestamp NOT NULL DEFAULT current_timestamp(),
  usuario_id int(11) DEFAULT NULL,
  accion varchar(255) DEFAULT NULL,
  descripcion text DEFAULT NULL,
  ip varchar(50) DEFAULT NULL,
  tabla_afectada varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla roles
--

CREATE TABLE roles (
  id_rol int(11) NOT NULL,
  nombre_rol varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla roles
--

INSERT INTO roles (id_rol, nombre_rol) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla usuarios
--

CREATE TABLE usuarios (
  id int(11) NOT NULL,
  password varchar(255) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  id_rol int(11) DEFAULT NULL,
  fecha_nacimiento date DEFAULT NULL,
  fecha_creacion date DEFAULT NULL,
  fecha_eliminacion date DEFAULT NULL,
  es_activo tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla logs
--
ALTER TABLE logs
  ADD PRIMARY KEY (id_log),
  ADD KEY usuario_id (usuario_id);

--
-- Indices de la tabla roles
--
ALTER TABLE roles
  ADD PRIMARY KEY (id_rol),
  ADD UNIQUE KEY nombre_rol (nombre_rol);

--
-- Indices de la tabla usuarios
--
ALTER TABLE usuarios
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email),
  ADD KEY id_rol (id_rol);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla logs
--
ALTER TABLE logs
  MODIFY id_log int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla roles
--
ALTER TABLE roles
  MODIFY id_rol int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla usuarios
--
ALTER TABLE usuarios
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla logs
--
ALTER TABLE logs
  ADD CONSTRAINT logs_ibfk_1 FOREIGN KEY (usuario_id) REFERENCES usuarios (id);

--
-- Filtros para la tabla usuarios
--
ALTER TABLE usuarios
  ADD CONSTRAINT usuarios_ibfk_1 FOREIGN KEY (id_rol) REFERENCES roles (id_rol);
COMMIT;
ALTER TABLE login.usuarios 
ADD COLUMN username VARCHAR(45) NULL AFTER es_activo;
