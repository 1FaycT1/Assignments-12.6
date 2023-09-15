<?php
$examplePersonsArray = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];
echo "Начало функции getFullNameFromParts<br>";
foreach ($examplePersonsArray as $person)
{
    $fullName = getFullNameFromParts($person['fullname']);
    
    echo "Полное имя: $fullName<br>";
    
}
echo "Конец функции getFullNameFromParts<br><br>";

echo "Начало функции getPartsFromFullname<br>";
foreach ($examplePersonsArray as $person) 
{
    $parts = getPartsFromFullname($person['fullname']);
    
    $surname = $parts['surname'];
    $name = $parts['name'];
    $paternity = $parts['paternity'];

    echo "Фамилия: $surname<br> Имя: $name<br> Отчество: $paternity<br>";
}
echo "Конец функции getPartsFromFullname<br>";

foreach ($examplePersonsArray as $person)
{
    $short = getShortName($person['fullname']);
    $surname = $short['surname'];
    $name = $short['name'];

    echo "Сокращенное имя: $name $surname<br><br>";

}

foreach ($examplePersonsArray as $person)
{
    $genders = getGenderFromName($person['fullname']);
    $surname = $genders['surname'];
    $name = $genders['name'];
    $paternity = $genders['paternity'];
    $gender = $genders['gender'];

    echo "$surname $name $paternity $gender <br>";
}

function getFullNameFromParts($fullname)
{
    $surnameNamePaternity = explode(' ', $fullname);
    $surname = $surnameNamePaternity[0];
    $name = $surnameNamePaternity[1];
    $paternity = $surnameNamePaternity[2];
    $nameInFull = $surname ." ". $name ." ". $paternity;

    return "$nameInFull";
}

function getPartsFromFullname($fullname) 
{
    // Используем функцию getFullNameFromParts для получения полного имени
    $nameInFull = getFullNameFromParts($fullname);

    // Разделяем полное имя на фамилию, имя и отчество
    list($surname, $name, $paternity) = explode(' ', $nameInFull);

    return 
    [
        'surname' => $surname,
        'name' => $name,
        'paternity' => $paternity
    ];
}

function getShortName ($fullname)
{
    $parts = getPartsFromFullname($fullname);
    $surname = $parts['surname'];
    $name = $parts['name'];

    return
    [
        'name' => $name,
        'surname' => mb_substr($surname, 0, 1)
    ];
}

function getGenderFromName ($fullname)
{
    $parts = getPartsFromFullname($fullname);
    $surname = $parts['surname'];
    $name = $parts['name'];
    $paternity = $parts['paternity'];

    //Объявляю переменную для определениея гендера	
	$gender = 0;
    //Проверка фамилии
    if (mb_substr($surname, -1) === "в") 
    {
        $gender++;
    }
    elseif (mb_substr($surname, -2) === "ва")
    {
        $gender--;
    }
    //Проверка имени
    if (mb_substr($name, -1) === "й" || mb_substr($name, -1) === "н")
    {
        $gender++;
    }
    elseif (mb_substr($name, -1) === "а")
    {
        $gender--;
    }
    //Проверка отчества
    if (mb_substr($paternity, -2) === "ич")
    {
        $gender++;
    }
    elseif(mb_substr($paternity, -3) === "вна")
    {
        $gender--;
    }
    //Определение гендера
    if ($gender > 0)
    {
        $gender = "Мужской";
    }
    elseif ($gender < 0)
    {
        $gender = "Женский";
    }
    elseif ($gender === 0)
    {
        $gender = "Неопределен";
    }
    //Задаю возврат данных в новый массив и прописываю ключи
    return  
    [
        'surname' => $surname,
        'name' => $name,
        'paternity' => $paternity,
        'gender' => $gender
    ];
}

function getGenderDescription($personsArray)
{
    $maleCount = 0;
    $femaleCount = 0;
    $undefinedCount = 0;
    $totalCount = count($personsArray);

    foreach ($personsArray as $person) {
        $genders = getGenderFromName($person['fullname']);
        $gender = $genders['gender'];

        // Увеличиваем соответствующий счетчик в зависимости от гендера
        if ($gender === "Мужской") {
            $maleCount++;
        } elseif ($gender === "Женский") {
            $femaleCount++;
        } else {
            $undefinedCount++;
        }
    }

    // Вычисляем проценты от общего числа и округляем до десятых
    $malePercentage = round(($maleCount / $totalCount) * 100, 1);
    $femalePercentage = round(($femaleCount / $totalCount) * 100, 1);
    $undefinedPercentage = round(($undefinedCount / $totalCount) * 100, 1);

    // Возвращаем результаты в виде ассоциативного массива
    return [
        'Мужской' => $malePercentage,
        'Женский' => $femalePercentage,
        'Неопределен' => $undefinedPercentage,
    ];
}
?>