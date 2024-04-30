-- Create Database
CREATE DATABASE IF NOT EXISTS LibraryManagement;
USE LibraryManagement;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Create Publisher Table
CREATE TABLE IF NOT EXISTS Publisher (
    PublisherId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Address VARCHAR(255) NOT NULL,
    CONSTRAINT Unique_Publisher_Name UNIQUE (Name)
);

-- Create Person Table
CREATE TABLE IF NOT EXISTS Person (
    PId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    CONSTRAINT Unique_Person_Name UNIQUE (Name)
);

-- Create Document Table
CREATE TABLE IF NOT EXISTS Document (
    DId INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    PublisherId INT NOT NULL,
    PublicationDate DATE NOT NULL,
    Type ENUM('Book', 'Journal Volume', 'Conference Proceedings') NOT NULL,
    ISBN VARCHAR(20),
    CONSTRAINT FK_Publisher FOREIGN KEY (PublisherId) REFERENCES Publisher(PublisherId),
    CONSTRAINT Unique_Document_Title UNIQUE (Title)
);

-- Create Author Table
CREATE TABLE IF NOT EXISTS Author (
    DId INT NOT NULL,
    PId INT NOT NULL,
    PRIMARY KEY (DId, PId),
    FOREIGN KEY (DId) REFERENCES Document(DId),
    FOREIGN KEY (PId) REFERENCES Person(PId)
);

-- Create Branch Table
CREATE TABLE IF NOT EXISTS Branch (
    BId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Location VARCHAR(255) NOT NULL,
    CONSTRAINT Unique_Branch_Name UNIQUE (Name)
);

-- Create Copy Table
CREATE TABLE IF NOT EXISTS Copy (
    CopyId INT AUTO_INCREMENT PRIMARY KEY,
    DId INT NOT NULL,
    BId INT NOT NULL,
    Position VARCHAR(10) NOT NULL,
    Status ENUM('Available', 'Reserved', 'Borrowed') NOT NULL,
    CONSTRAINT Unique_Copy_Id UNIQUE (CopyId),
    FOREIGN KEY (DId) REFERENCES Document(DId),
    FOREIGN KEY (BId) REFERENCES Branch(BId)
);

-- Create Reader Table
CREATE TABLE IF NOT EXISTS Reader (
    RId INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Address VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(20) NOT NULL,
    Type ENUM('Student', 'Senior Citizen', 'Staff') NOT NULL,
    CONSTRAINT Unique_Reader_PhoneNumber UNIQUE (PhoneNumber)
);

-- Create Reservation Table
CREATE TABLE IF NOT EXISTS Reservation (
    RNum INT AUTO_INCREMENT PRIMARY KEY,
    RId INT NOT NULL,
    CopyId INT NOT NULL,
    ReservationDate DATETIME NOT NULL,
    CONSTRAINT Unique_Reservation_Number UNIQUE (RNum),
    FOREIGN KEY (RId) REFERENCES Reader(RId),
    FOREIGN KEY (CopyId) REFERENCES Copy(CopyId),
    CONSTRAINT Check_ReservationDate CHECK (HOUR(ReservationDate) < 18) -- Reserved copies must be picked up before 6 pm
);

-- Create Borrowing Table
CREATE TABLE IF NOT EXISTS Borrowing (
    BNum INT AUTO_INCREMENT PRIMARY KEY,
    RId INT NOT NULL,
    CopyId INT NOT NULL,
    BorrowDate DATE NOT NULL,
    ReturnDate DATE,
    FineAmount DECIMAL(10, 2),
    CONSTRAINT Unique_Borrowing_Number UNIQUE (BNum),
    FOREIGN KEY (RId) REFERENCES Reader(RId),
    FOREIGN KEY (CopyId) REFERENCES Copy(CopyId),
    CONSTRAINT Check_BorrowDate_ReturnDate CHECK (ReturnDate >= BorrowDate) -- Return date must be greater than or equal to borrow date
);

-- Create Editor Table
CREATE TABLE IF NOT EXISTS Editor (
    PId INT NOT NULL,
    Name VARCHAR(255) NOT NULL,
    Role ENUM('Journal Chief Editor', 'Guest Editor') NOT NULL,
    PRIMARY KEY (PId, Role),
    FOREIGN KEY (PId) REFERENCES Person(PId)
);

-- Create Journal Volume Table
CREATE TABLE IF NOT EXISTS JournalVolume (
    VolumeId INT AUTO_INCREMENT PRIMARY KEY,
    DId INT NOT NULL,
    Number INT NOT NULL,
    FOREIGN KEY (DId) REFERENCES Document(DId)
);

-- Create Journal Issue Table
CREATE TABLE IF NOT EXISTS JournalIssue (
    IssueId INT AUTO_INCREMENT PRIMARY KEY,
    VolumeId INT NOT NULL,
    Number INT NOT NULL,
    Scope VARCHAR(255),
    FOREIGN KEY (VolumeId) REFERENCES JournalVolume(VolumeId)
);

-- Create Fine Table
CREATE TABLE IF NOT EXISTS Fine (
    FineId INT AUTO_INCREMENT PRIMARY KEY,
    BNum INT NOT NULL,
    FineDate DATE NOT NULL,
    FineAmount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (BNum) REFERENCES Borrowing(BNum)
);
