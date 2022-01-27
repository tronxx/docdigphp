create table facturas (
	idfactura			integer NOT NULL AUTO_INCREMENT,
	folio				integer,
	serie				varchar(50),
	nombre				varchar(100),
	fecha				varchar(50),
	timbrado			varchar(10),
	uuid				varchar(50),
	fechatimbrado		varchar(50),
	status				varchar(10),
	total				varchar(20),
	primary key (idfactura)
);

commit work;


update  facturas set status = 'ACTIVO' where status is null;
update facturas set total = '0' where  total is null;

commit work;
