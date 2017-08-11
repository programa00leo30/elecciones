--sqls----
-- CREATE VIEW "NOMBRE_VISTA" AS "Instrucción SQL";
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `votosMesas`
--
DROP VIEW IF EXISTS `votosMesas`;
CREATE OR REPLACE
ALGORITHM = UNDEFINED
VIEW `votosMesas` AS 
SELECT 
`mesa`.fecha as fecha ,
`mesa`.tiempo as tiempo ,
`mesa`.TotalVontantes as TotalVotantes ,
`mesa`.idDistrito as idDistrito ,
`mesa`.idSeccion as idSeccion ,
`mesa`.idCircuito as idCircuito,
`mesa`.VotosBlancos as VotosBlancos, 
`mesa`.VotosNulos as VotosNulos ,
`mesa`.VotosRecurridos as VotosRecurridos ,
`mesa`.VotosInpugnados as VotosInpugnados ,
`mesadetalle`.idlista as idlista ,
`mesadetalle`.idCargo as idCargo ,
sum(`mesadetalle`.cantidad ) as Votos ,    
count(`mesadetalle`.cantidad ) as SUmino , 
count(`mesa`.id) as SUman
FROM `mesa` 
	left join `mesadetalle` 
		on `mesa`.id = `mesadetalle`.idMesa 
group by `idDistrito` , `idseccion`, `idCircuito` , `idCargo` , `idLista`
    
------------------------------- fin...
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `SubEnLista`
--
DROP VIEW IF EXISTS `SubEnLista`;
CREATE OR REPLACE
ALGORITHM = UNDEFINED
VIEW `SubEnLista` AS
    select `d`.idCargo ,
    `c`.idLista ,
	`d`.id as idCandidato ,
	concat(`d`.nombre , ", " , `d`.apellido ) as candiato
    from 
    `candidatosEnLista` as c 
		left join 
    		`candidatos` as d 
    			on `d`.id = `c`.idCandidato
    group by c.idLista, d.idCargo

------------------------------- fin...

--
-- Estructura Stand-in para la vista `PartEnLista`
--
DROP VIEW IF EXISTS `PartEnLista`;
CREATE OR REPLACE
ALGORITHM = UNDEFINED
VIEW `PartEnLista` AS 
SELECT  
`f`.`id`as idPart,
`f`.`NroLista` as NroPartido,
`f`.`AgrupacionPolitica`,
`listas`.`id` as id ,
`listas`.`NroLista`,
`listas`.`nombre`

FROM `listas` left join 
	partidos as f
on `f`.id = `listas`.idPartido
group by listas.id

------------------------------- fin...
-- --------------------------------------------------------

--
-- Estructura para la vista `EnLista`
--
DROP TABLE IF EXISTS `EnLista`;

CREATE OR REPLACE 
ALGORITHM=UNDEFINED DEFINER=`c0740032`@`%` 
SQL SECURITY DEFINER 
VIEW `EnLista` AS 
select 
	`listas`.`id`         AS `id`,
	`listas`.`idPart`     AS `idPart`,
	`listas`.`NroPartido` AS `NroPartido`,
	`listas`.`AgrupacionPolitica` AS `AgrupacionPolitica`,
	`listas`.`NroLista`   AS `NroLista`,
	`listas`.`nombre`     AS `nombre`,
	max(if((`f`.`idCargo` = 2),1,0)) AS `Senador`,
	max(if((`f`.`idCargo` = 3),1,0)) AS `diputado`,
	
	max(if((`f`.`idCargo` = 2),f.idCandidato ,0) ) AS `SenadorCandiato` ,
	max(if((`f`.`idCargo` = 3),f.idCandidato ,0 ))  AS `DiputadoCandiato`
 

from (`PartEnLista` `listas` 
	left join `SubEnLista` `f` 
	on((`listas`.`id` = `f`.`idLista`))) 
group by `listas`.`id`


------------------------------- fin...
-- --------------------------------------------------------
--
-- Estructura para la vista `EnLista`
--

DROP VIEW IF EXISTS `CandidatosPorPartido`;
CREATE OR REPLACE
ALGORITHM = UNDEFINED
VIEW `CandidatosPorPartido` AS 
select 
   p.id as idPartido,   l.id as idLista,
   c.id as id ,   c.nombre ,
   c.apellido,    c.idCargo
from partidos as p
	left join listas as l 
		left join candidatosEnLista as e
			left join candidatos as c
			on e.idCandidato = c.id
		on l.id = e.idLista
on p.id = l.idPartido

----------------------------------- estas son todas las views creadas
---------------------------------------------------------------------

CREATE VIEW "votosPorLista" AS 
-- candidatos en listas:
SELECT  `listas`.id as idELista,
 	NroLista ,	AgrupacionPolitica ,	activo ,
 		`candidatosEnLista`.id as idECandidato,
 		 	idCandidato ,
 		 		idLista ,
 		 			`candidatosEnLista`.idCargo  ,
 		 				`candidatos`.id as idEcandi ,
 		 					nombre ,	apellido ,
 		 						`candidatos`.idCargo as cargo
 FROM `listas` 
left join `candidatosEnLista` 
left join `candidatos` 
on `candidatosEnLista`.idCandidato = `candidatos`.id
on `candidatosEnLista`.idLista = `listas`.id   ;

-- detalles de mesas
select * from mesa left join mesadetalle on mesadetalle.idMesa = mesa.id  ;


--[[

SELECT c.name FROM sys.columns c JOIN sys.tables t ON c.object_id = t.object_id WHERE t.name = 'listas' ;

./runsql "SELECT * FROM information_schema.COLUMNS WHERE information_schema.TABLE_NAME='candidatos' ;  "
-- VER LA INFORMACION DE LA TABLA SEGUN NOMBRE DE TALBA.
-- AGREGAR FILTRO PARA TABLE_SCHEMA ( nombre de la database )
./runsql "SELECT i.TABLE_SCHEMA, i.TABLE_NAME, i.COLUMN_NAME , i.COLUMN_TYPE, i.COLUMN_KEY FROM information_schema.COLUMNS as i WHERE i.TABLE_SCHEMA='c0740032_algo' and i.TABLE_NAME='usuarios' ;  "

create function f_promedio
 (@valor1 decimal(4,2),
  @valor2 decimal(4,2)
 )
 returns decimal (6,2)
 as
 begin 
   declare @resultado decimal(6,2)
   set @resultado=(@valor1+@valor2)/2
   return @resultado
 end;

create function f_nombreMes
 (@fecha datetime='2017/10/01')
  returns varchar(10)
  as
  begin
    declare @nombre varchar(10)
    set @nombre=
     case datename(month,@fecha)
       when 'January' then 'Enero'
       when 'February' then 'Febrero'
       when 'March' then 'Marzo'
       when 'April' then 'Abril'
       when 'May' then 'Mayo'
       when 'June' then 'Junio'
       when 'July' then 'Julio'
       when 'August' then 'Agosto'
       when 'September' then 'Setiembre'
       when 'October' then 'Octubre'
       when 'November' then 'Noviembre'
       when 'December' then 'Diciembre'
     end--case
    return @nombre
 end;
 
--]]

-------------------- 
-- consultas especiales
--------------------

-- verificar que las mesas tengan la cantidad de datos correctos.



-- borrar una mesa.
DELETE FROM `c0740032_algo`.`mesa` WHERE `mesa`.`id` = 31

--- borrado especial con condicionamiento extremo.
DELETE FROM `c0740032_algo`.`mesa` 
WHERE
 id IN (
	select a.id as id from (
		select 
			m.id , 
			count(d.id) as cantidad  
		from mesa as m 
		   left join mesadetalle as d 
		  on m.id = d.idMesa

		group by m.id
	   ) as aDROP VIEW IF EXISTS `votosMesas`;
CREATE OR REPLACE
ALGORITHM = UNDEFINED
VIEW `votosMesas` AS 
	where a.cantidad < 17
	limit 0, 5
)

--- sql para candidatos.
DROP VIEW IF EXISTS `CandidatosPorPartido`;
CREATE OR REPLACE
ALGORITHM = UNDEFINED
VIEW `CandidatosPorPartido` AS 
select 
   p.id as idPartido,   l.id as idLista,
   c.id as id ,   c.nombre ,
   c.apellido,    c.idCargo
from partidos as p
	left join listas as l 
		left join candidatosEnLista as e
			left join candidatos as c
			on e.idCandidato = c.id
		on l.id = e.idLista
on p.id = l.idPartido

