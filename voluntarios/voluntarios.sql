Create Database Voluntarios

Create Table `Paises` (
	`id_pais` INT NOT NULL AUTO_INCREMENT,
	`nombre_pais` varchar(50) NOT NULL UNIQUE,
	`nacionalidad` varchar(50),
	`idioma_oficial` VARCHAR(50),
	PRIMARY KEY (`id_pais`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Ocupaciones` (
	`id_ocupacion` INT NOT NULL AUTO_INCREMENT,
	`ocupacion` varchar(50) NOT NULL UNIQUE,
	PRIMARY KEY (`id_ocupacion`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Usuarios` (
	`id_usuario` INT NOT NULL AUTO_INCREMENT,
	`email` varchar(50) NOT NULL Unique,
	`clave` varchar(50),
	`tipo_usuario` varchar(20) Check(`tipo_usuario` in ('Voluntario', 'Organizacion', 'Administrador')),
	`fecha_usuario_creado` datetime,
	PRIMARY KEY (`id_usuario`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table Voluntarios(
	`id_voluntario` INT NOT NULL AUTO_INCREMENT,
	`id_usuario` INT NOT NULL,
	`primer_nombre` varchar(30) NOT NULL,
	`segundo_nombre` varchar(30),
	`primer_apellido` varchar(30) NOT NULL,
	`segundo_apellido` varchar(30),
	`sexo` Char(1) Check (`sexo` in ('M', 'F')),
	`fecha_nacimiento` date,
	`ciudad_nacimiento` varchar(50),
	`nacionalidad` varchar(50),
	`estado_civil` varchar(20) Check(`estado_civil` in ('Soltero', 'Casado', 'Divorciado', 'Viudo', 'Union Libre', 'Separado')),
	`nivel_educacion` varchar(20) Check(`nivel_educacion` in ('primaria', 'bachiller', 'universitario', 'maestria', 'doctorado')),
	`id_ocupacion` INT,
	`tipo_sangre` Char(3) Check(`tipo_sangre` in ('O+', 'A+', 'B+', 'AB+', 'O-', 'A-', 'B-', 'AB-')),
	`es_conductor` varchar(2) Check(`es_conductor` in ('Si', 'No')),
	`vehiculo_propio` Char(2) Check(`vehiculo_propio` in ('Si', 'No')),
	`brigada` varchar(50),
	`rango` varchar(50),
	`esta_activo` Char(2) Check(`esta_activo` in ('Si', 'No')),
	`tipo_direccion` Varchar(20) Check(`tipo_direccion` in ('casa', 'apartamento')),
	`id_pais` INT NOT NULL,
	`provincia` VARCHAR(50),
	`ciudad` varchar(50),
	`direccion` varchar(90),
	`codigo_postal` varchar(20),
	PRIMARY KEY (`id_voluntario`),
	FOREIGN KEY (`id_usuario`) REFERENCES Usuarios(`id_usuario`),
	FOREIGN KEY (`id_pais`) REFERENCES Paises(`id_pais`),
	FOREIGN KEY (`id_ocupacion`) REFERENCES Ocupaciones(`id_ocupacion`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Entrenamiento` (
	`id_entrenamiento` INT NOT NULL AUTO_INCREMENT,
	`nombre_entrenamiento` varchar(50) NOT NULL,
	`tipo_entrenamiento` varchar(50),
	PRIMARY KEY (`id_entrenamiento`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Entrenamiento_Voluntario` (
	`id_entrenamiento` INT NOT NULL,
	`id_voluntario` INT NOT NULL,
	`es_certificado` Char(2) Check(`es_certificado` in ('Si', 'No')),
	`fecha_certificado` date,
	Primary Key(`id_entrenamiento`, `id_voluntario`),
	FOREIGN KEY (`id_entrenamiento`) REFERENCES Entrenamiento(`id_entrenamiento`),
	FOREIGN KEY (`id_voluntario`) REFERENCES Voluntarios(`id_voluntario`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Identificaciones` (
	`id_identificacion` INT NOT NULL AUTO_INCREMENT,
	`tipo_identificacion` varchar(20) NOT NULL UNIQUE Check(`tipo_identificacion` in ('Cedula', 'Pasaporte', 'Licencia de Conducir')),
	PRIMARY KEY (`id_identificacion`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Identificacion_Voluntario` (
	`id_identificacion` INT NOT NULL,
	`id_voluntario` INT NOT NULL,
	`num_identificacion` varchar(50) NOT NULL UNIQUE,
	Primary Key(`id_identificacion`, `id_voluntario`),
	FOREIGN KEY (`id_identificacion`) REFERENCES Identificaciones(`id_identificacion`),
	FOREIGN KEY (`id_voluntario`) REFERENCES Voluntarios(`id_voluntario`)	
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Telefonos` (
	`telefono` varchar(10) NOT NULL,
	`tipo_telefono` varchar(50) UNIQUE,
	PRIMARY KEY(`telefono`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Telefono_Usuario` (
	`telefono` varchar(10) NOT NULL,
	`id_usuario` INT NOT NULL,
	`BB_PIN` char(8),
	Primary Key(`telefono`, `id_usuario`),
	FOREIGN KEY (`telefono`) REFERENCES Telefonos(`telefono`),
	FOREIGN KEY (`id_usuario`) REFERENCES Usuarios(`id_usuario`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Organizaciones` (
	`id_organizacion` INT NOT NULL AUTO_INCREMENT,
	`id_usuario` INT NOT NULL,
	`nombre_organizacion` varchar(50) NOT NULL UNIQUE,
	`tipo_organizacion` varchar(50),
	`id_pais` INT NOT NULL,
	`provincia` varchar(30),
	`ciudad` varchar(50),
	`direccion` varchar(90),
	`codigo_postal` varchar(20),
	PRIMARY KEY(`id_organizacion`),
	FOREIGN KEY (`id_usuario`) REFERENCES Usuarios(`id_usuario`),
	FOREIGN KEY (`id_pais`) REFERENCES Paises(`id_pais`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Eventos` (
	`id_evento` INT NOT NULL AUTO_INCREMENT,
	`nombre_evento` varchar(50) NOT NULL,
	`nombre_lugar` varchar(90) NOT NULL,
	`id_pais` INT NOT NULL,
	`provincia` varchar(50),
	`fecha_hora_inicio` datetime,
	`fecha_hora_fin` datetime,
	`tipo_evento` varchar(20),
	`tipo_frecuencia` varchar(20) NOT NULL,
	`tipo_compromiso` varchar(20),
	`cant_voluntarios_solicitado` varchar(10),
	`descripcion` varchar(500),
	`fecha_evento_creado` datetime,
	PRIMARY KEY (`id_evento`),
	FOREIGN KEY (`id_pais`) REFERENCES Paises(`id_pais`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Evento_Organizacion` (
	`id_evento` int NOT NULL,
	`id_organizacion` int NOT NULL,
	Primary Key (`id_evento`, `id_organizacion`),
	FOREIGN KEY (`id_evento`) REFERENCES Eventos(`id_evento`),
	FOREIGN KEY (`id_organizacion`) REFERENCES Organizaciones(`id_organizacion`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Entrenamiento_Evento` (
	`id_entrenamiento` int NOT NULL,
	`id_evento` int NOT NULL,
	Primary Key(`id_entrenamiento`, `id_evento`),
	FOREIGN KEY (`id_entrenamiento`) REFERENCES Entrenamiento(`id_entrenamiento`),
	FOREIGN KEY (`id_evento`) REFERENCES Eventos(`id_evento`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;

Create Table `Voluntario_Evento` (
	`id_voluntario` int NOT NULL,
	`id_evento` int NOT NULL,
	Primary Key(`id_voluntario`, `id_evento`),
	FOREIGN KEY (`id_voluntario`) REFERENCES Voluntarios(`id_voluntario`),
	FOREIGN KEY (`id_evento`) REFERENCES Eventos(`id_evento`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8;


Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('República Dominicana', 'Dominicano', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Haití', 'Haitiano', 'Francés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Estados Unidos', 'Estadounidense', 'Inglés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Afganistán', 'Afgano', 'Afgano');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Alemania', 'Alemán', 'Alemán');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Arabia Saudita', 'Árabe', 'Árabe');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Argentina', 'Argentino', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Australia', 'Australiano', 'Inglés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Bélgica', 'Belga', 'Francés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Bolivia', 'Boliviano', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Brasil', 'Brasilero', 'Portugués');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Camboya', 'Camboyano', 'Camboyano');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Canadá', 'Canadiense', 'Inglés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Chile', 'Chileno', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('China', 'Chino', 'Chino');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Colombia', 'Colombiano', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Corea', 'Coreano', 'Coreano');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Costa Rica', 'Costarricense', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Cuba', 'Cubano', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Dinamarca', 'Danés', 'Danés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Ecuador', 'Ecuatoriano', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Egipto', 'Egipcio', 'Árabe');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('El Salvador', 'Salvadoreño', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('España', 'Español', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Estonia', 'Estonio', 'Estonio');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Etiopia', 'Etiope', 'Amárico');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Filipinas', 'Filipino', 'Tagalo');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Francia', 'Francés', 'Francés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Gales', 'Galés', 'Galés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Grecia', 'Griego', 'Griego');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Guatemala', 'Guatemalteco', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Holanda', 'Holandés', 'Holandés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Honduras', 'Hondureño', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Indonesia', 'Indonés', 'Indonesio');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Inglaterra', 'Inglés', 'Inglés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Irak', 'Iraquí', 'Árabe');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Irán', 'Iraní', 'Persa');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Irlanda', 'Irlandés', 'Irlandés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Israel', 'Israelí', 'Hebreo');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Italia', 'Italiano', 'Italiano');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Japón', 'Japonés', 'Japonés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Jordania', 'Jordano', 'Árabe');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Laos', 'Laosiano', 'Laosiano');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Letonia', 'Letón', 'Letón');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Litania', 'Letonés', 'Lituano');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Malasia', 'Malayo', 'Malayo');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Marrueco', 'Marroquí', 'Árabe');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('México', 'Mexicano', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Nicaragua', 'Nicaragüense', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Noruega', 'Noruego', 'Noruego');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Nueva Zelanda', 'Neocelandés', 'Inglés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Panamá', 'Panameño', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Paraguay', 'Paraguayo', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Perú', 'Peruano', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Polonia', 'Polaco', 'Polaco');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Portual', 'Portugués', 'Portugués');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Puerto Rico', 'Puertorriqueño', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Rumania', 'Rumano', 'Rumano');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Rusia', 'Ruso', 'Ruso');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Suecia', 'Sueco', 'Sueco');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Suiza', 'Suizo', 'Suizo');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Tailandia', 'Tailandés', 'Tailandés');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Taiwán', 'Taiwanes', 'Chino');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Turquía', 'Turco', 'Turco');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Ucrania', 'Ucraniano', 'Ucraniano');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Uruguay', 'Uruguayo', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Venezuela', 'Venezolano', 'Español');
Insert into `Paises` (`nombre_pais`, `nacionalidad`, `idioma_oficial`) Values('Vietnam', 'Vietnamita', 'Vietnamita');

Insert into `Ocupaciones` (`ocupacion`) Values('Estudiante');
Insert into `Ocupaciones` (`ocupacion`) Values('Abogado');
Insert into `Ocupaciones` (`ocupacion`) Values('Ama de Casa');
Insert into `Ocupaciones` (`ocupacion`) Values('Arquitecto');
Insert into `Ocupaciones` (`ocupacion`) Values('Bombero');
Insert into `Ocupaciones` (`ocupacion`) Values('Cajero');
Insert into `Ocupaciones` (`ocupacion`) Values('Carnicero');
Insert into `Ocupaciones` (`ocupacion`) Values('Carpintero');
Insert into `Ocupaciones` (`ocupacion`) Values('Cartero');
Insert into `Ocupaciones` (`ocupacion`) Values('Cocinero');
Insert into `Ocupaciones` (`ocupacion`) Values('Constructor');
Insert into `Ocupaciones` (`ocupacion`) Values('Contador');
Insert into `Ocupaciones` (`ocupacion`) Values('Dentista');
Insert into `Ocupaciones` (`ocupacion`) Values('Economista');
Insert into `Ocupaciones` (`ocupacion`) Values('Electricista');
Insert into `Ocupaciones` (`ocupacion`) Values('Enfermera');
Insert into `Ocupaciones` (`ocupacion`) Values('Farmacéutico');
Insert into `Ocupaciones` (`ocupacion`) Values('Foógrafo');
Insert into `Ocupaciones` (`ocupacion`) Values('Guardian');
Insert into `Ocupaciones` (`ocupacion`) Values('Herrero');
Insert into `Ocupaciones` (`ocupacion`) Values('Ingeniero');
Insert into `Ocupaciones` (`ocupacion`) Values('Instructor');
Insert into `Ocupaciones` (`ocupacion`) Values('Juez');
Insert into `Ocupaciones` (`ocupacion`) Values('Locutor');
Insert into `Ocupaciones` (`ocupacion`) Values('Marinero');
Insert into `Ocupaciones` (`ocupacion`) Values('Mecánico');
Insert into `Ocupaciones` (`ocupacion`) Values('Médico');
Insert into `Ocupaciones` (`ocupacion`) Values('Minero');
Insert into `Ocupaciones` (`ocupacion`) Values('Niñera');
Insert into `Ocupaciones` (`ocupacion`) Values('Panadero');
Insert into `Ocupaciones` (`ocupacion`) Values('Peluquero');
Insert into `Ocupaciones` (`ocupacion`) Values('Periodista');
Insert into `Ocupaciones` (`ocupacion`) Values('Pescador');
Insert into `Ocupaciones` (`ocupacion`) Values('Piloto');
Insert into `Ocupaciones` (`ocupacion`) Values('Pintor');
Insert into `Ocupaciones` (`ocupacion`) Values('Político');
Insert into `Ocupaciones` (`ocupacion`) Values('Profesor');
Insert into `Ocupaciones` (`ocupacion`) Values('Programador');
Insert into `Ocupaciones` (`ocupacion`) Values('Psicólogo');
Insert into `Ocupaciones` (`ocupacion`) Values('Recepcionista');
Insert into `Ocupaciones` (`ocupacion`) Values('Reportero');
Insert into `Ocupaciones` (`ocupacion`) Values('Retirado');
Insert into `Ocupaciones` (`ocupacion`) Values('Sastre');
Insert into `Ocupaciones` (`ocupacion`) Values('Secretaria');
Insert into `Ocupaciones` (`ocupacion`) Values('Supervisor');
Insert into `Ocupaciones` (`ocupacion`) Values('Taxista');
Insert into `Ocupaciones` (`ocupacion`) Values('Técnico');
Insert into `Ocupaciones` (`ocupacion`) Values('Vendedor');

Insert into `Entrenamiento` (`nombre_entrenamiento`, `tipo_entrenamiento`) Values('Control de Incendios', 'Emergencias');
Insert into `Entrenamiento` (`nombre_entrenamiento`, `tipo_entrenamiento`) Values('Primeros Auxilios', 'Emergencias');
Insert into `Entrenamiento` (`nombre_entrenamiento`, `tipo_entrenamiento`) Values('Rescate', 'Emergencias');


SELECT vol.`sexo`, ROUND(DATEDIFF(NOW(), vol.`fecha_nacimiento`)/365, 0) AS Edad, vol.`nacionalidad`, vol.`estado_civil`, vol.`nivel_educacion`,
 ocu.`ocupacion`, vol.`tipo_sangre`, vol.`es_conductor`, vol.`vehiculo_propio`, Paises.`nombre_pais`, Eventos.`tipo_evento` 
 FROM `Voluntarios` `vol`, `Ocupaciones` `ocu`, Paises, Eventos, Voluntario_Evento `ve` 
 WHERE vol.`id_ocupacion` = `ocu`.`id_ocupacion` and vol.`id_pais` = Paises.`id_pais` and Eventos.`id_evento` = ve.`id_evento` 
 and vol.`id_voluntario` = ve.`id_voluntario`;

CREATE VIEW v_Datos_Voluntarios AS (SELECT vol.`sexo`, ROUND(DATEDIFF(NOW(), vol.`fecha_nacimiento`)/365, 0) AS Edad, vol.`nacionalidad`, 
vol.`estado_civil`, vol.`nivel_educacion`, ocu.`ocupacion`, vol.`tipo_sangre`, vol.`es_conductor`, vol.`vehiculo_propio`, 
Paises.`nombre_pais`, Eventos.`tipo_evento` 
FROM `Voluntarios` `vol`, `Ocupaciones` `ocu`, Paises, Eventos, Voluntario_Evento `ve` 
WHERE vol.`id_ocupacion` = `ocu`.`id_ocupacion` and vol.`id_pais` = Paises.`id_pais` and Eventos.`id_evento` = ve.`id_evento` 
and vol.`id_voluntario` = ve.`id_voluntario`);

SELECT * FROM `v_Datos_Voluntarios`;


