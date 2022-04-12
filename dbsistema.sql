CREATE DATABASE dbsistemaprestamos;
USE dbsistemaprestamos;
CREATE TABLE DatosGenerales
(
  idDatosGenerales INT NOT NULL AUTO_INCREMENT,
  nombres VARCHAR(30) NOT NULL,
  primerApellido VARCHAR(30) NOT NULL,
  segundoApellido VARCHAR(30) NOT NULL,
  correoInstitucional VARCHAR(25) NOT NULL,
  PRIMARY KEY (idDatosGenerales)
);

CREATE TABLE ProgramaEducativo
(
  idProgramaEducativo INT NOT NULL AUTO_INCREMENT,
  programasEducativos VARCHAR(5) NOT NULL,
  PRIMARY KEY (idProgramaEducativo)
);

CREATE TABLE Anaquel
(
  idAnaquel INT NOT NULL AUTO_INCREMENT,
  anaquelNumero VARCHAR(20) NOT NULL,
  descripcionAnaquel VARCHAR(100) NOT NULL, 
  PRIMARY KEY (idAnaquel)
);

CREATE TABLE TipoArticulo
(
  idTipoArticulo INT NOT NULL AUTO_INCREMENT,
  tipoArticulo VARCHAR(30) NOT NULL,
  PRIMARY KEY (idTipoArticulo)
);

CREATE TABLE Cargos
(
  idCargo INT NOT NULL AUTO_INCREMENT,
  cargoCliente VARCHAR(30) NOT NULL,
  PRIMARY KEY (idCargo)
);

CREATE TABLE Clientes
(
  idClientes INT NOT NULL AUTO_INCREMENT,
  matricula INT NOT NULL,
  idDatosGenerales INT NOT NULL ,
  idProgramaEducativo INT NOT NULL,
  idCargo INT NOT NULL,
  PRIMARY KEY (idClientes),
  FOREIGN KEY (idDatosGenerales) REFERENCES DatosGenerales(idDatosGenerales),
  FOREIGN KEY (idProgramaEducativo) REFERENCES ProgramaEducativo(idProgramaEducativo),
  FOREIGN KEY (idCargo) REFERENCES Cargos(idCargo)
);

CREATE TABLE Usuarios
(
  idUsuarios INT NOT NULL AUTO_INCREMENT,
  rolUsuario VARCHAR(15) NOT NULL,
  contrasenaUsuario VARCHAR(64) NOT NULL,
  aliasUsuario VARCHAR(25) NOT NULL,
  imagen VARCHAR(50) NULL,
  idDatosGenerales INT NOT NULL ,
  PRIMARY KEY (idUsuarios),
  FOREIGN KEY (idDatosGenerales) REFERENCES DatosGenerales(idDatosGenerales)
);

CREATE TABLE Prestamos
(
  idPrestamo INT NOT NULL AUTO_INCREMENT,
  edificio CHAR(4) NOT NULL,
  tipoArea VARCHAR(25) NOT NULL,
  descripcionArea VARCHAR(100) NOT NULL,
  estado VARCHAR(15) NOT NULL,
  folio VARCHAR(10) NULL,
  fechaPrestamo DATE NOT NULL,
  fechaCierre DATE NULL,
  idClientes INT NOT NULL ,
  PRIMARY KEY (idPrestamo),
  FOREIGN KEY (idClientes) REFERENCES Clientes(idClientes)
);

CREATE TABLE Articulos
(
  idArticulo INT NOT NULL AUTO_INCREMENT,
  etiqueta VARCHAR(30) NOT NULL,
  fechaAlta DATE NOT NULL,
  numeroSerie VARCHAR(50) NOT NULL,
  imagen VARCHAR(50) NOT NULL, 
  descripcion VARCHAR(256) NOT NULL,
  codigoBarras VARCHAR(50) NOT NULL,
  disponibilidadArticulos VARCHAR(20) NOT NULL,
  condicionArticulo VARCHAR(15) NOT NULL,
  idAnaquel INT NOT NULL,
  idTipoArticulo INT NOT NULL,
  PRIMARY KEY (idArticulo),
  FOREIGN KEY (idAnaquel) REFERENCES Anaquel(idAnaquel),
  FOREIGN KEY (idTipoArticulo) REFERENCES TipoArticulo(idTipoArticulo)
);

CREATE TABLE Baja
(
  idBaja INT NOT NULL AUTO_INCREMENT,
  fechaBaja DATE NOT NULL,
  observacionBaja VARCHAR(256) NOT NULL,
  idArticulo INT NOT NULL ,
  PRIMARY KEY (idBaja),
  FOREIGN KEY (idArticulo) REFERENCES Articulos(idArticulo)
);

CREATE TABLE Servicio
(
  idServicio INT NOT NULL AUTO_INCREMENT,
  tipoServicio VARCHAR(15) NOT NULL,
  fechaServicio DATE NOT NULL,
  idPrestamo INT NOT NULL ,
  idUsuarios INT NOT NULL ,
  PRIMARY KEY (idServicio, idPrestamo, idUsuarios),
  FOREIGN KEY (idPrestamo) REFERENCES Prestamos(idPrestamo),
  FOREIGN KEY (idUsuarios) REFERENCES Usuarios(idUsuarios)
);

CREATE TABLE ArticulosPrestamos
(
  idArticuloPrestamo INT NOT NULL AUTO_INCREMENT,
  fechaEntrega DATE NOT NULL,
  condicionEntrega VARCHAR(15) NOT NULL,
  devuelto BIT NOT NULL,
  fechaDevolucion DATE NULL,
  condicionDevolucion VARCHAR(15) NULL,
  observacionDevolucion VARCHAR(256) NULL,
  idArticulo INT NOT NULL ,
  idPrestamo INT NOT NULL ,
  PRIMARY KEY (idArticuloPrestamo, idArticulo, idPrestamo),
  FOREIGN KEY (idArticulo) REFERENCES Articulos(idArticulo),
  FOREIGN KEY (idPrestamo) REFERENCES Prestamos(idPrestamo)
);