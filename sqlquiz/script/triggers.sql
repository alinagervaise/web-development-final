-- 1. (1.1) « I can not access the evaluation before the date and time it has been scheduled for my class. »
-- raise exception 3001 before insert on test

delimiter $$
drop trigger if exists test_insert $$
create trigger test_insert
before insert on test
for each row 
begin
	DECLARE eval_start DATETIME;
    DECLARE msg VARCHAR(255);
    SELECT scheduled_at into eval_start
    from evaluation 
    where evaluation_id = new.evaluation_id;
    
	IF NEW.started_at < eval_start THEN
		SET msg =  concat('Cannot start Evaluation:', new.evaluation_id, 
        " scheduled at:", eval_start);
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT= msg, MYSQL_ERRNO=3001;
	END if;
end $$

-- 2. (1.5) « The evaluation has also a maximal ending time, which is greater than the scheduled time plus the
-- maximal duration.
-- The difference takes in account the time to create and populate the database. »
-- => raise exception 3002 before insert or update on evaluation
delimiter $$
drop trigger if exists evaluation_insert_max_duration $$
create trigger evaluation_insert_max_duration
before insert on evaluation
for each row 
begin
    DECLARE msg VARCHAR(255);

	IF TIMESTAMPDIFF(MINUTE, NEW.scheduled_at, NEW.ending_at)  <  NEW.nb_minutes THEN
		SET msg =  concat('Please  check that inserted maximum duration is greater than: ', NEW.nb_minutes);
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT= msg, MYSQL_ERRNO=3002;
	END if;
end $$

delimiter $$
drop trigger if exists evaluation_update_max_duration $$
create trigger evaluation_update_max_duration
before update on evaluation
for each row 
begin
    DECLARE msg VARCHAR(255);

	IF TIMESTAMPDIFF(MINUTE, NEW.scheduled_at, NEW.ending_at)  <  NEW.nb_minutes THEN
		SET msg =  concat('Please  check that updated maximum duration is greater than: ', NEW.nb_minutes);
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT= msg, MYSQL_ERRNO=3002;
	END if;
end $$


-- 3.(1.8) « I can not see any question before I have started the evaluation.
-- (I see none during the creation and populating process). »
-- => UI issue + raise exception 3003 in before insert on sql_answer
-- 4.(1.19) « I can no more validate any answer when my evaluation is terminated. »
-- => raise exception 3004 in before insert or update on sql_answer

delimiter $$
drop trigger if exists sql_answer_insert $$
create trigger sql_answer_insert
before update on sql_answer
for each row 
begin
	DECLARE eval_start DATETIME;
    DECLARE eval_end DATETIME;
    DECLARE buffer_time INT;
    DECLARE msg VARCHAR(255);
    
    SELECT scheduled_at , nb_minutes, ending_at into eval_start, buffer_time, eval_end
    from evaluation 
    where evaluation_id = new.evaluation_id;
    
	IF (NOW() < eval_start or NOW() > eval_end) and (NEW.query != old.query) THEN
		SET msg =  concat('Sorry, you cannot  submit your answers' );
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT= msg, MYSQL_ERRNO=3003;
	END if;
end $$





-- 5.(3.4) « If the class evaluation is not completed, I can validate or invalidate any question in the student evaluation
-- (we call that « complete the question »). »
-- => raise exception 3005 in before update on sql_answer
delimiter $$
drop trigger if exists  sql_answer_update_complete_question $$
create trigger sql_answer_update_complete_question
before update on sql_answer
for each row
	begin 
		DECLARE eval_end datetime;
		DECLARE msg VARCHAR(255);
		select completed_at into eval_end 
			from evaluation 
			where evaluation_id = new.evaluation_id;
		if (eval_end < NOW())  and (new.is_validated != old.is_validated) then
			set msg = concat( "The evaluation is completed , you can no longer complete question");
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT= msg, MYSQL_ERRNO=3005;
	END if;
end $$


 
-- 6.(3.8) « The student evaluation is marked as completed when and only when I have completed all of its
-- questions. »
-- => raise exception 3006 in before update on test
delimiter $$
drop trigger if exists test_update $$
create trigger test_update
before update on test
for each row
begin 
	declare nb_questions int;
    declare nb_validated_questions int;
    declare msg varchar(255);
    
	select count(question_id) , COUNT(IF(is_validated=1,1, NULL)) into nb_questions, nb_validated_questions
    from sql_answer
    where (student_id = new.student_id) and (evaluation_id = new.evaluation_id);
    
    if (nb_questions != nb_validated_questions) then
		set msg = concat("Please complete all the answers before validating test");
		signal sqlstate '45000'
		SET MESSAGE_TEXT= msg, MYSQL_ERRNO=3006;
	END if;
end $$

-- 7.(design issue) Create empty sql_answer rows after insert test, in order to have empty answers already recorded
-- (you only have to update them when the student set his answers).

delimiter $$
drop trigger if exists test_insert $$
create trigger test_insert
after insert on test
for each row
begin 
	
	insert  into  sql_answer(question_id, student_id, evaluation_id,query)
	select q_id, NEW.student_id, NEW.evaluation_id, ""
    from
    (select q.question_id  as q_id from quiz_question q left join evaluation e
              on  e.quiz_id = q.quiz_id 
              where e.evaluation_id = NEW.evaluation_id) as questions;
  
end $$