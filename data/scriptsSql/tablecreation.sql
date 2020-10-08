create table Commande(
idcommande integer(5) auto_increment,
idcompte integer(5) not null,
idspectacle integer(5) not null,
datecommande datetime default NOW() not null,

constraint pk_idcommande primary key(idcommande),
constraint fk_idcompte foreign key(idcompte) references Compte(idcompte),
constraint fk_idspectacle foreign key(idspectacle) references Spectacle(idspectacle)
);

create table Spectacle(
idspectacle integer(5) auto_increment,
nomspectacle varchar(30) not null,
resumespectacle varchar(200) not null,
datespectacle dateTime not null,
lieuxspectacle varchar(30) not null,
affiche varchar(20) not null,
nbplaces integer(5) default 50 not null,

constraint pk_spectacle primary key(idspectacle)
);

create table Compte(
idcompte integer(5) auto_increment,
nom varchar(30) not null,
prenom varchar(30) not null,
email varchar(30) not null,
adresse varchar(40) not null,
status varchar(10) not null,
hashmdp varchar(255) not null,

constraint pk_idcompte primary key(idcompte)
);