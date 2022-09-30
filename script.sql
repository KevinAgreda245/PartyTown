create database PartyTown;

create table Slider(
    idSlider int not null primary key AUTO_INCREMENT,
    tituloSlider varchar(50),
    subtituloSlider varchar(50),
    fotoSlider varchar(100)
);

create table TipoUsuario(
    idTipoUsuario int not null primary key AUTO_INCREMENT,
    tipoUsuario varchar(50) not null
);

create table Usuario(
    idUsuario int not null primary key AUTO_INCREMENT,
    nombreUsuario varchar(50) not null,
    apellidoUsuario varchar(50) not null,
    correoUsuario varchar(80) not null,
    claveUsuario varchar(100) not null,
    fotoUsuario varchar(100) not null,
    fechaNacimiento date not null,
    telefonoUsuario varchar(9),
    idTipoUsuario int not null,
    foreign key (idTipoUsuario) references TipoUsuario(idTipoUsuario)
);

create table Cliente(
    idCliente int not null primary key AUTO_INCREMENT,
    nombreCliente varchar(50) not null,
    apellidoCliente varchar(50) not null,
    generoCliente int not null,
    correoCliente varchar(70) not null,
    claveCliente varchar(100) not null,
    telefonoCliente varchar(9) not null,
    fechaNacimiento date not null,
    estadoCliente int not null
);

create table TipoProducto(
    idTipoProducto int not null primary key AUTO_INCREMENT,
    tipoProducto varchar(40) not null,
    descripcionTipo varchar(100) not null,
    fotoTipoProducto varchar(100) not null
);

create table TipoEvento(
    idTipoEvento int not null primary key AUTO_INCREMENT,
    tipoEvento varchar(40) not null,
    descripcionTipo varchar(100) not null,
    fotoTipoEvento varchar(100) not null
);

create table Proveedor(
    idProveedor int not null primary key AUTO_INCREMENT,
    nombreProveedor varchar(50) not null,
    telefonoProveedor varchar(9) not null,
    logoProveedor varchar(100) not null
);
create table Producto(
    idProducto int not null primary key AUTO_INCREMENT,
    nombreProducto varchar(60) not null,
    descripcionProducto varchar(100) not null,
    precioProducto float not null,
    cantidadProducto int not null,
    fotoProducto varchar(100) not null,
    estadoProducto int not null,
    idTipoProducto int not null,
    idTipoEvento int not null,
    idProveedor int not null,
    foreign key (idTipoProducto) references TipoProducto(idTipoProducto),
    foreign key (idTipoEvento) references TipoEvento(idTipoEvento),
    foreign key (idProveedor) references Proveedor(idProveedor)
);

create table ComentarioProducto(
    idComentario int not null primary key AUTO_INCREMENT,
    idProducto int not null,
    idCliente int not null, 
    descripcionComentario varchar(120) not null,
    foreign key (idProducto) references Producto(idProducto),
    foreign key (idCliente) references Cliente(idCliente)
);

create table ValoracionProducto(
    idValoracion int not null primary key AUTO_INCREMENT,
    valoracionProducto int not null,
    idProducto int not null,
    idCliente int not null, 
    foreign key (idProducto) references Producto(idProducto),
    foreign key (idCliente) references Cliente(idCliente)
);

create table Comentario(
    idComentario int not null primary key AUTO_INCREMENT,
    nombreComentario varchar(50) not null,
    apellidoComentario varchar(50) not null,
    correoComentario varchar(50) not null,
    descripcionComentario varchar(120) not null
);

create table Factura(
    idFactura int not null primary key AUTO_INCREMENT,
    fechahoraFactura datetime not null,
    direccionFactura varchar(100) not null,
    estadoFactura int not null,
    idCliente int not null,
    foreign key (idCliente) references Cliente(idCliente)
);

create table DetalleFactura(
    idDetalle int not null primary key AUTO_INCREMENT,
    idFactura int not null,
    idProducto int not null,
    cantidadProducto int not null,
    foreign key (idProducto) references Producto(idProducto),
    foreign key (idFactura) references Factura(idFactura) 
);

create table Bitacora(
    idBitacora int not null primary key AUTO_INCREMENT,
    fechahoraBitacora int not null,
    idUsuario int not null,
    accionBitacora varchar(200) not null,
    foreign key (idUsuario) references Usuario(idUsuario)
);