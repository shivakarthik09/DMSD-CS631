INSERT INTO Reader (Name, Address, PhoneNumber, Type) VALUES
('John Doe', '123 Main St, Seattle, WA 98101', '111-111-1111', 'Student'),
('Alice Johnson', '456 Elm St, Seattle, WA 98102', '222-222-2222', 'Senior Citizen'),
('Bob Smith', '789 Oak St, Seattle, WA 98103', '333-333-3333', 'Student'),
('Sarah Lee', '321 Pine St, Seattle, WA 98104', '444-444-4444', 'Staff'),
('Emily Brown', '654 Cedar St, Seattle, WA 98105', '555-555-5555', 'Senior Citizen'),
('Michael Clark', '987 Walnut St, Seattle, WA 98106', '666-666-6666', 'Student'),
('Laura Martinez', '741 Maple St, Seattle, WA 98107', '777-777-7777', 'Staff'),
('David Wilson', '852 Birch St, Seattle, WA 98108', '888-888-8888', 'Student'),
('Emma Taylor', '369 Chestnut St, Seattle, WA 98109', '999-999-9999', 'Senior Citizen'),
('James Anderson', '147 Spruce St, Seattle, WA 98110', '101-101-1010', 'Staff');


INSERT INTO Publisher (Name, Address) VALUES
('Penguin Random House', '1745 Broadway, New York, NY 10019'),
('HarperCollins Publishers', '195 Broadway, New York, NY 10007'),
('Macmillan Publishers', '120 Broadway, New York, NY 10271'),
('Simon & Schuster', '1230 Avenue of the Americas, New York, NY 10020'),
('Hachette Book Group', '1290 Avenue of the Americas, New York, NY 10104'),
('Scholastic Corporation', '557 Broadway, New York, NY 10012'),
('Pearson PLC', '80 Strand, London WC2R 0RL, United Kingdom'),
('Oxford University Press', 'Great Clarendon Street, Oxford OX2 6DP, United Kingdom'),
('Cambridge University Press', 'University Printing House, Shaftesbury Road, Cambridge CB2 8BS, United Kingdom'),
('Bloomsbury Publishing', '50 Bedford Square, London WC1B 3DP, United Kingdom');

INSERT INTO Person (Name) VALUES
('John Doe'),
('Jane Smith'),
('Alice Johnson'),
('Bob Brown'),
('Emily Davis'),
('Michael Wilson'),
('Sarah Taylor'),
('David Clark'),
('Laura Martinez'),
('James Anderson');

INSERT INTO Document (Title, PublisherId, PublicationDate, Type, ISBN) VALUES
('The Great Gatsby', 1, '1925-04-10', 'Book', '978-0-7432-7356-5'),
('To Kill a Mockingbird', 2, '1960-07-11', 'Book', '978-0-06-112008-4'),
('National Geographic Volume 1', 1, '1888-09-22', 'Journal Volume', NULL),
('Conference Proceedings of IEEE 2021', 3, '2021-10-01', 'Conference Proceedings', NULL),
('Harry Potter and the Sorcerer''s Stone', 4, '1997-06-26', 'Book', '978-0-7475-3269-6'),
('Scientific American Volume 1', 2, '1845-08-28', 'Journal Volume', NULL),
('Conference Proceedings of ACM 2020', 3, '2020-09-01', 'Conference Proceedings', NULL),
('1984', 1, '1949-06-08', 'Book', '978-0-452-28423-4'),
('Nature Volume 1', 4, '1869-11-04', 'Journal Volume', NULL),
('Conference Proceedings of AAAI 2019', 2, '2019-01-01', 'Conference Proceedings', NULL);

INSERT INTO Author (DId, PId) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

INSERT INTO Branch (Name, Location) VALUES
('Central Library', '1000 Fourth Ave, Seattle, WA 98104'),
('North Branch', '8901 35th Ave NE, Seattle, WA 98115'),
('South Branch', '4850 Rainier Ave S, Seattle, WA 98118'),
('West Branch', '2301 Delridge Way SW, Seattle, WA 98106'),
('East Branch', '4450 NE 10th St, Renton, WA 98059'),
('Downtown Branch', '900 Broadway, Seattle, WA 98122'),
('University Branch', '5009 Roosevelt Way NE, Seattle, WA 98105'),
('Lake City Branch', '12501 28th Ave NE, Seattle, WA 98125'),
('Ballard Branch', '5614 22nd Ave NW, Seattle, WA 98107'),
('Beacon Hill Branch', '2821 Beacon Ave S, Seattle, WA 98144');

INSERT INTO Copy (DId, BId, Position, Status) VALUES
(1, 1, '001A03', 'Available'),
(2, 2, '002B02', 'Reserved'),
(3, 3, '003C01', 'Borrowed'),
(4, 4, '004D01', 'Available'),
(5, 5, '005E01', 'Available'),
(6, 6, '006F01', 'Reserved'),
(7, 7, '007G01', 'Borrowed'),
(8, 8, '008H01', 'Available'),
(9, 9, '009I01', 'Available'),
(10, 10, '010J01', 'Available');

INSERT INTO Reservation (RId, CopyId, ReservationDate) VALUES
(8, 1, '2022-05-01 10:00:00'),
(9, 2, '2022-05-02 11:00:00'),
(10, 3, '2022-05-03 12:00:00'),
(11, 4, '2022-05-04 13:00:00'),
(12, 5, '2022-05-05 14:00:00'),
(13, 6, '2022-05-06 15:00:00'),
(14, 7, '2022-05-07 16:00:00'),
(15, 8, '2022-05-08 10:00:00'), -- Adjusted time to before 6 PM
(16, 9, '2022-05-09 11:00:00'), -- Adjusted time to before 6 PM
(17, 10, '2022-05-10 12:00:00'); -- Adjusted time to before 6 PM

INSERT INTO Borrowing (RId, CopyId, BorrowDate, ReturnDate, FineAmount) VALUES
(8, 1, '2022-06-01', '2022-06-21', 2.00),
(9, 2, '2022-06-02', '2022-06-20', NULL),
(10, 3, '2022-06-03', NULL, 0.75),
(11, 4, '2022-06-04', NULL, NULL),
(12, 5, '2022-06-05', NULL, NULL),
(13, 6, '2022-06-06', '2022-06-22', 1.00),
(14, 7, '2022-06-07', '2022-06-19', NULL),
(15, 8, '2022-06-08', NULL, NULL),
(16, 9, '2022-06-09', '2022-06-18', NULL),
(17, 10, '2022-06-10', '2022-06-25', NULL);

INSERT INTO Editor (PId, Name, Role) VALUES
(1, 'John Smith', 'Journal Chief Editor'),
(2, 'Jane Doe', 'Guest Editor'),
(3, 'Alice Johnson', 'Journal Chief Editor'),
(4, 'Bob Brown', 'Guest Editor'),
(5, 'Emily Davis', 'Journal Chief Editor'),
(6, 'Michael Wilson', 'Guest Editor'),
(7, 'Sarah Taylor', 'Journal Chief Editor'),
(8, 'David Clark', 'Guest Editor'),
(9, 'Laura Martinez', 'Journal Chief Editor'),
(10, 'James Anderson', 'Guest Editor');

INSERT INTO JournalVolume (DId, Number) VALUES
(3, 1),
(6, 2),
(9, 3),
(3, 2),
(6, 3),
(9, 4),
(3, 3),
(6, 4),
(9, 5),
(3, 1);

INSERT INTO JournalIssue (VolumeId, Number, Scope) VALUES
(1, 1, 'Introduction to Computational Biology'),
(2, 2, 'Advances in Quantum Mechanics'),
(3, 3, 'Innovations in Renewable Energy Technologies'),
(4, 1, 'Exploring Artificial Intelligence Applications'),
(5, 2, 'Trends in Climate Change Research'),
(6, 3, 'Insights into Neurobiology and Brain Disorders'),
(7, 1, 'Recent Developments in Materials Science'),
(8, 2, 'Emerging Trends in Nanotechnology'),
(9, 3, 'Perspectives on Sustainable Agriculture'),
(10, 1, 'Evolutionary Biology: Current Research and Future Directions');

INSERT INTO Fine (BNum, FineDate, FineAmount) VALUES
(1, '2022-06-22', 2.00), -- Fine of $2.00 for BNum 1 on June 22, 2022
(2, NULL, NULL), -- No fine for BNum 2
(3, NULL, NULL), -- No fine for BNum 3
(4, '2022-06-25', 3.50), -- Fine of $3.50 for BNum 4 on June 25, 2022
(5, '2022-06-30', 1.75), -- Fine of $1.75 for BNum 5 on June 30, 2022
(6, NULL, NULL), -- No fine for BNum 6
(7, NULL, NULL), -- No fine for BNum 7
(8, '2022-07-05', 5.00), -- Fine of $5.00 for BNum 8 on July 5, 2022
(9, NULL, NULL), -- No fine for BNum 9
(10, '2022-07-10', 2.25); -- Fine of $2.25 for BNum 10 on July 10, 2022







