-- (1.1) « I can not access the evaluation before the date and time it has been scheduled for my class. »
-- => raise exception 3001 before insert on test
-- User table should have at least one user
-- Class table needs at least  2 values
-- Class_member will link the user with only one class value
-- create an evaluation for both classes
-- e class, 2 trainers, at least 3 students, 6 row for class_member, 2 evaluation for 1 trainer in a , 2 quiz, 4 or 5 questions by quiz, 1 evaluation for 1st trainer in the 2nd clas  for 2 quiz, 1 evaluation for 1st trainer in the 1nd clas  for 1, 2 quiz; 3 tests for evaluation 1, 3 test for evluation 1 ; 1 with all answers; 1 with 3answers, 1 wtih 2 answers
/* Reset procedure declaration and call, which populate the table */

DELIMITER $$
DROP PROCEDURE IF EXISTS init_db $$
CREATE PROCEDURE init_db()
BEGIN
   SET FOREIGN_KEY_CHECKS=0;
  TRUNCATE user;
  TRUNCATE class;
  TRUNCATE class_member;
  TRUNCATE trainer;
  TRUNCATE quiz_question;
  TRUNCATE sql_answer;
  TRUNCATE sql_question;
  TRUNCATE evaluation;
  TRUNCATE quiz;
  TRUNCATE test;

	SET FOREIGN_KEY_CHECKS=1;
  -- create at least 5 users
  INSERT INTO user(user_id,email, pwd, name, first_name)
  VALUES
  (1, "trainer1@gmail.com", "trainer1", "TRAINER1", "Jean"),
  (2, "trainer2@gmail.com", "trainer2", "TRAINER2", "Marie"),
  (3, "student1@gmail.com", "student1", "STUDENT1", "Paul"),
  (4, "student2@gmail.com", "student2", "STUDENT2", "Laura"),
  (5, "student3@gmail.com", "student3", "STUDENT3", "Andrew"),
  (6, "student4@gmail.com", "student4", "STUDENT4", "Amanda"),
  (7, "student5@gmail.com", "student5", "STUDENT5", "Rihanna"),
  (8, "student6@gmail.com", "student6", "STUDENT6", "Louis");
 
 -- Create at least 2 classes
 INSERT INTO class (class_id, name)
 VALUES 
  (1, "SQL class for French Student"),
  (2, "SQL class for International Student");
  
  -- Create at least 2 trainers
 
 INSERT INTO trainer (user_id) 
 VALUES
  (1),
  (2);
 
  -- register at least 3 students into in the class
  INSERT INTO class_member(user_id,class_id)
  VALUES
  (3, 1),
  (4, 1),
  (5, 1),
  (6, 2),
  (7, 2),
  (8, 2);
  -- create 2 quizzes at least
  INSERT INTO quiz (quiz_id, title, db_name,diagram_path,creation_script_path)
  VALUES
  (1, "QUIZ1", "plane_db","diagram_path1","creation_script_path"),
  (2, "QUIZ2", "plane_db","diagram_path2","creation_script_path");
  
   -- insert all the answers to all quizzes
  INSERT INTO sql_question(question_id, question_text,correct_answer)
  VALUES
  (1, "question 1 label", "answer1"),
  (2, "question 2 label", "answer2"),
  (3, "question 3 label", "answer3"),
  (4, "question 4 label", "answer4"),
  (5, "question 5 label", "answer5"),
  (6, "question 6 label", "answer6"),
  (7, "question 7 label", "answer7"),
  (8, "question 8 label", "answer8"),
  (9, "question 9 label", "answer9"),
  (10, "question 10 label", "answer10");
  
  
  -- create at least 5 questions per quiz
  
  INSERT INTO quiz_question(question_id, quiz_id, rank)
  VALUES
  (1, 1, 1),
  (2, 1, 2),
  (3, 1, 3),
  (4, 1, 4),
  (5, 1, 5),
  (6, 2, 1),
  (7, 2, 2),
  (8, 2, 3),
  (9, 2, 4),
  (10, 2, 5);

  -- create 1 evaluation per class, complete_at means every test is graded by the trainer
  INSERT INTO evaluation (evaluation_id,scheduled_at,ending_at,nb_minutes,class_id,trainer_id, quiz_id,completed_at)
  VALUES
  (1, "2017-06-14 10:00", "2017-06-14 10:50", 30, 1, 1, 1, "2017-06-15 20:45"),
  (2, "2017-06-14 10:00", "2017-06-14 11:00", 40, 2, 2, 2, "2017-06-15 23:45"),
  (3, "2017-06-14 10:00", "2017-06-14 11:00", 60, 1, 2, 1, "2017-06-17 10:00");
 
  -- create 3 tests for evaluation 1
  INSERT INTO test(student_id,evaluation_id,started_at,completed_at,validated_at)
  VALUES
  (3, 1, "2017-06-14 10:02","2017-06-14 10:45","2017-06-15 09:00"),
  (4, 1, "2017-06-14 10:05","2017-06-14 10:59","2017-06-15 10:00"),
  (5, 1, "2017-06-14 10:05","2017-06-14 10:59","2017-06-15 10:00");
  
  -- create all answers for student , 3 answer for second student, 2 answer for the third student
  INSERT INTO sql_answer(question_id, student_id, evaluation_id,query,is_validated,gives_correct_result)
  VALUES
  (1, 3, 1, "answer1", 1, 1),
  (2, 3, 1, "answer2", 1, 1),
  (3, 3, 1, "answer3", 0, 1),
  (4, 3, 1, "answer4", 1, 1),
  (5, 3, 1, "answer145", 0, 0),
  (1, 4, 1, "answer1", 1, 1),
  (5, 4, 1, "answer178", 1, 0),
  (4, 4, 1, "answer4", 0, 1),
  (1, 5, 1, "answer1", 1, 1),
  (2, 5, 1, "answer2", 1, 1);
 
END $$

call init_db()$$