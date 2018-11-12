# Elevator

## Задача:

1) Спроектировать иерархию классов пассажирского лифта на базе его основных составляющих и общих принципов их взаимодействия.
2) Сформулировать основные функциональные требования к системе.
3) Основные классы и взаимоотношения между ними отобразить на диаграмме классов.
4) Реализовать на PHP сценарий, в котором человек вызывает лифт.

В детализации и способах представления информации ограничений нет.

## Реализация:

### Основные функциональные требования к системе

* Пользователю должно быть доступно вызвать лифт на любом этаже с помощью кнопок со стрелкой вверх или вниз;
* Если у пользователя есть намерение подняться с помощью лифта на верхний этаж, он нажимает кнопку со стрелкой вверх;
* Если у пользователя есть намерение спуститься с помощью лифта на нижний этаж, он нажимает кнопку со стрелкой вниз;
* Если пользователь находится внутри лифта, он выбирает этаж и нажимает кнопку с номером этажа на который намеревается добраться;
* Лифт должен собирать пользователей на этажах, по мере его движения вверх или вниз в зависимости от нажатых кнопок со стрелками;
* На количество пользователей внутри лифта ограничений нет;
* Лифт должен автоматически открывать и закрывать двери для того чтобы впустить или выпустить пользователя;
* Пользователь сам решает когда ему входить или выходить из лифта;
* Отдельный скрипт должен уметь генерировать и выполнять сценарий с заданным количеством пользователей, количеством этажей в здании, а также отображать пошагово действия каждого пользователя и лифта с помощью текстовых информационных сообщений.


## Требования:
> PHP >= 7.1.0

## Установка:

> composer install

## Использование:

Скрипт сценария генерируется каждый раз случайным образом, выдавая задачи каждому пользователю как независимому объекту.
Для запуска скрипта сценария, необходимо зайти в директорию "scenario" и запустить следующий скрипт:

> php elevator.php

    1 user(s) are added to the scenario
    The scenario has been genereted
    Strarting the scenario ...
    [ELEVATOR] 8th floor; Users: 0
    [USER 1] Task: 6 -> 7
    [USER 1] I click on a UpButton. I am waiting the elevator
    [ELEVATOR] 7th floor; Users: 0
    [ELEVATOR] 6th floor; Users: 0
    [ELEVATOR] Door is opened
    [USER 1] I enter the elevator. I'm inside
    [USER 1] I click on the 7th floor button.
    [ELEVATOR] 6th floor; Users: 1
    [ELEVATOR] Door is closed
    [ELEVATOR] 6th floor; Users: 1
    [ELEVATOR] 7th floor; Users: 1
    [ELEVATOR] Door is opened
    [USER 1] I got out of the elevator
    [USER 1] My task has been completed
    [ELEVATOR] 7th floor; Users: 0
    [ELEVATOR] Door is closed
    [ELEVATOR] 7th floor; Users: 0
    [USER 1] Task: 7 -> 6
    [USER 1] I click on a DownButton. I am waiting the elevator
    [ELEVATOR] Door is opened
    [USER 1] I enter the elevator. I'm inside
    [USER 1] I click on the 6th floor button.
    [ELEVATOR] 7th floor; Users: 1
    [ELEVATOR] Door is closed
    [ELEVATOR] 7th floor; Users: 1
    [ELEVATOR] 6th floor; Users: 1
    [ELEVATOR] Door is opened
    [USER 1] I got out of the elevator
    [USER 1] My task has been completed
    [ELEVATOR] 6th floor; Users: 0
    [ELEVATOR] Door is closed

## Настройка:

Для настройки скрипта сценария, необходимо открыть файл:

> config/config.php

> 'floors' => количество этажей в здании

> 'users' => количество пользователей участвующих в сценарии
