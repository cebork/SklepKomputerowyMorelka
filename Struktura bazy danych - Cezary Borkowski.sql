create database morelka;
use morelka;
create table users (
	user_id INTEGER AUTO_INCREMENT primary key,
    login varchar(1000) NOT NULL,
    haslo varchar(1000) NOT NULL,
    PL INTEGER,
    data_zalozenia DATE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table dane_personalne (
	dane_id integer AUTO_INCREMENT PRIMARY KEY,
    user_id integer not null unique,
    imie varchar(1000) NOT NULL,
    nazwisko varchar(1000) NOT NULL,
    email varchar(1000) NOT NULL,
    telefon integer,
    miejscowosc varchar(1000) not null,
    kod_pocztowy varchar(1000) not null,
    ulica varchar(1000) not null,
    nr_domu varchar(1000) not null
);

create table employees (
	employee_id INTEGER AUTO_INCREMENT primary key,
    user_id INTEGER unique not null,
    pobory integer not null,
    data_zatrudnienia Date not null,
    stanowisko_id INTEGER not null
);

create table stanowiska (
	stanowisko_id INTEGER AUTO_INCREMENT primary key,
    nazwa varchar(100) not null
);


create table zamowienia (
	zamowienia_id INTEGER AUTO_INCREMENT primary key,
    user_id INTEGER NOT NULL,
    data DATE,
    sposob_platnosci_id INTEGER,
    dostawca_id INTEGER,
    cena INTEGER NOT NULL,
    status_id INTEGER NOT NULL
);

create table sposoby_platnosci (
	sposob_platnosci_id INTEGER AUTO_INCREMENT primary key,
    nazwa varchar(100) not null,
    cena integer not null
);

create table dostawcy (
	dostawca_id INTEGER AUTO_INCREMENT primary key,
    nazwa varchar(100) not null,
    cena integer not null
);

create table statusy (
	status_id INTEGER AUTO_INCREMENT primary key,
    status VARCHAR(50) NOT NULL
);

create table zawartoscZamowienia (
	zawartosc_item_id INTEGER AUTO_INCREMENT primary key,
    zamówienie_id INTEGER NOT NULL,
    item_id INTEGER NOT NULL,
    ilosc INTEGER NOT NULL,
    cena INTEGER NOT NULL
);

create table kategorie (
	kategoria_id INTEGER AUTO_INCREMENT primary key,
    nazwa varchar(100) NOT NULL
);

create table podkategorie (
	podkategoria_id INTEGER auto_increment NULL primary key,
    podkategoria_nazwa varchar(1000) NOT NULL,
    podkategoria_nazwa_tabeli varchar(1000) NOT NULL,
    kategoria_id integer NOT NULL
);
create table items (
	item_id INTEGER AUTO_INCREMENT primary key,
    nazwa varchar(1000) NOT NULL,
    ilosc INTEGER NOT NULL,
    kupione integer NOT NULL DEFAULT 0,
    model varchar(1000) not null,
    producent varchar(1000) not null,
    waga float NOT NULL,
    wysokosc integer NOT NULL,
    szerokosc integer NOT NULL,
    dlugosc integer NOT NULL,
    data_produkcji date not null,
    podkategoria_id INTEGER NOT NULL,
    cena integer NOT NULL,
    usuniety boolean NOT NULL DEFAULT false 
);
create table images (
	img_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    item_id INTEGER not null,
    ext varchar(10) not null,
    status integer not null
);
create table komputery(
	komputer_id INTEGER AUTO_INCREMENT primary key,
    procesor varchar(1000) not null,
    RAM integer not null,
    dysk_twardy integer not null,
    karta_graficzna varchar(1000),
    zasilacz varchar(1000) not null,
    obudowa varchar(1000) not null,
    item_id INTEGER unique not null
);

create table procesory (
	procesor_id INTEGER AUTO_INCREMENT primary key,
    taktowanie float not null,
	pamiec_cache integer not null,
    pobor_mocy integer not null,
    item_id INTEGER unique not null
);

create table plytyGlowne (
	plyta_glowna_id INTEGER AUTO_INCREMENT primary key,
    typ_socketu varchar(100) not null,
	ilosc_slotow_RAM integer not null,
    typ_płyty varchar(1000),
    item_id INTEGER unique not null
);

create table RAM (
	RAM_id INTEGER AUTO_INCREMENT primary key,
    typ_pamieci varchar(30) not null,
    taktowanie integer not null,
	ilosc_pamieci integer not null,
    pobor_mocy integer not null,
    item_id INTEGER unique not null
);

create table hardDrive (
	hardDrive_id INTEGER AUTO_INCREMENT primary key,
    typ_dysku varchar(30) not null,
    szybkosc_zapisu integer not null,
    szybkosc_odczytu integer not null,
	ilosc_pamieci integer not null,
    pobor_mocy integer not null,
    item_id INTEGER unique not null
);

create table kartyGraficzne (
	karta_graficzna_id INTEGER AUTO_INCREMENT primary key,
    taktowanie integer not null,
	ilosc_pamieci integer not null,
    pobor_mocy integer not null,
    item_id INTEGER unique not null
);

create table zasilcze (
	zasilacz_id INTEGER AUTO_INCREMENT primary key,
    moc integer not null,
    decybele integer not null,
    item_id INTEGER unique not null
);

create table obudowy (
	obudowa_id INTEGER AUTO_INCREMENT primary key,
    typ_obudowy varchar(30) not null,
    item_id INTEGER unique not null
);

create table myszki (
	myszka_id INTEGER AUTO_INCREMENT primary key,
    DPI integer not null,
    czy_bezprzewodowa boolean not null DEFAULT 0,
    item_id INTEGER unique not null 
);

create table klawiatury (
	klawiatura_id INTEGER AUTO_INCREMENT primary key,
    typ_switcha varchar(100),
    czy_bezprzewodowa boolean not null DEFAULT 0,
    item_id INTEGER unique not null
);


-- klucze obce
ALTER TABLE zamowienia ADD FOREIGN KEY (status_id) REFERENCES statusy(status_id);
ALTER TABLE zamowienia ADD FOREIGN KEY (user_id) REFERENCES users(user_id);
ALTER TABLE dane_personalne ADD foreign key (user_id) references users(user_id);
ALTER TABLE zawartoscZamowienia ADD FOREIGN KEY (zamówienie_id) REFERENCES zamowienia(zamowienia_id);
ALTER TABLE zawartoscZamowienia ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE podkategorie ADD FOREIGN KEY (kategoria_id) REFERENCES kategorie(kategoria_id);
ALTER TABLE items ADD FOREIGN KEY (podkategoria_id) REFERENCES podkategorie(podkategoria_id);
ALTER TABLE myszki ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE klawiatury ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE komputery ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE procesory ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE plytyGlowne ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE RAM ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE hardDrive ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE kartyGraficzne ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE zasilcze ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE obudowy ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE images ADD FOREIGN KEY (item_id) REFERENCES items(item_id);
ALTER TABLE employees ADD FOREIGN KEY (user_id) REFERENCES users(user_id);
ALTER TABLE employees ADD FOREIGN KEY (stanowisko_id) REFERENCES stanowiska(stanowisko_id);
ALTER TABLE zamowienia ADD FOREIGN KEY (sposob_platnosci_id) REFERENCES sposoby_platnosci(sposob_platnosci_id);
ALTER TABLE zamowienia ADD FOREIGN KEY (dostawca_id) REFERENCES dostawcy(dostawca_id);