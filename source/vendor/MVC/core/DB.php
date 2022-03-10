<?php
namespace Reensq\plugin\core;

use PDO;
use PDOException;
use Reensq\plugin\lib\jQuery;

/**
 * Interface LoggerDB
 * Интерфейс класса DB
 * 
 * @package Reensq\plugin\core
 * @file source/vendor/MVC/core/DB.php
 * @author Reensq foundation
 */
interface LoggerDB {

    /**
     * Проверяем объект self
     *
     * @return object|DB
     */
    public static function instance();

    /**
     * Создаём объект PDO
     *
     * @return object|PDO|string
     */
    public static function db();

    /**
     * Подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
     *
     * @param string $sql SQL запрос
     * @return bool|mixed|\PDOStatement
     */
    public static function prepare($sql);

    /**
     * Запускает подготовленный запрос
     *
     * @param string $sql SQL запрос
     * @return bool|mixed
     */
    public static function execute($sql);

    /**
     * Выполняет SQL-запрос и возвращает результирующий набор в виде объекта PDO
     * 
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return bool|\PDOStatement|string
     */
    public static function query($sql, $params = []);

    /**
     * Возвращает массив, содержащий все строки результирующего набора
     * 
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return array
     */
    public static function row($sql, $params = []);

    /**
     * Возвращает данные одного столбца следующей строки результирующего набора
     *
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return int|mixed
     */
    public static function column($sql, $params = []);

    /**
     * Извлекает строку и возвращает ее в виде объекта
     *
     * @param string $class имя класса создаваемого объекта.
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return mixed
     */
    public static function object($class, $sql, $params = []);

    /**
     * Возвращает количество столбцов в результирующем наборе
     *
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return int
     */
    public static function columnCount($sql, $params = []);

    /**
     * Возвращает количество строк, затронутых SQL-запросом
     *
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return int
     */
    public static function rowCount($sql, $params = []);

    /**
     * Выполняет SQL-запрос и возвращает количество затронутых строк
     *
     * @param string $sql SQL запрос
     * @return false|int
     */
    public static function exec($sql);

    /**
     * Возвращает метаданные столбца в результирующей таблице
     *
     * @param int $num индекс (начиная с 0) столбца результирующего набора.
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return array|false
     */
    public static function getMeta($num, $sql, $params = []);

    /**
     * Получение значения атрибута запроса PDOStatement
     *
     * @param int $attr атрибут
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return mixed
     */
    public static function getAttr($attr, $sql, $params = []);

    /**
     * Устанавливает атрибут объекту PDOStatement
     *
     * @param int $attr атрибут
     * @param mixed $val значение атрибута
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return bool|mixed
     */
    public static function setAttr($attr, $val, $sql, $params = []);

    /**
     * Устанавливает режим выборки по умолчанию для объекта запроса
     *
     * @param mixed $mode режим выборки можно задавать только одной из констант PDO::FETCH_*.
     * @param string $sql SQL запрос
     * @param array $params массив с элементами для заполнения placeholder в SQL запросе
     * @return bool
     */
    public static function setFetch($mode, $sql, $params = []);

}

/**
 * Class DB
 * 
 * Это класс для работы с базой данных
 * Основан на технологии PDO
 *
 * @package Reensq\plugin\core
 * @author Reensq foundation
 */
class DB implements LoggerDB {

    /**
     * Объект для класса self
     * 
     * @var object
     */
    protected static $instance;

    /**
     * Количество SQL запросов
     * 
     * @var int
     */
    public static $countSQL = 0;

    /**
     * SQL запросы
     * 
     * @var array
     */
    public static $queries = [];

    /**
     * Конфигурация для PDO
     * 
     * @var array
     */
    const PDO_OPTIONS = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function db() {
        try {
            return new PDO(
                'mysql:host=localhost;dbname=host1380908_reensq', 
                'host1380908_reen', 
                'jon35015', 
                self::PDO_OPTIONS
            );
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
    }

    public static function prepare($sql) {
        return self::db()->prepare($sql);
    }

    public static function execute($sql) {
        self::$countSQL++;
        self::$queries[] = $sql;

        $stmt = self::prepare($sql);
        return $stmt->execute();
    }

    public static function query($sql, $params = []) {
        self::$countSQL++;
        self::$queries[] = $sql;

        $stmt = self::prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
        }

        $stmt->execute();

        return $stmt;
    }

    public static function row($sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function column($sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->fetchColumn();
    }

    public static function object($class, $sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->fetchObject($class);
    }

    public static function columnCount($sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->columnCount();
    }

    public static function rowCount($sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->rowCount();
    }

    public static function exec($sql) {
        return self::db()->exec($sql);
    }

    public static function getMeta($num, $sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->getColumnMeta($num);
    }

    public static function getAttr($attr, $sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->getAttribute($attr);
    }

    public static function setAttr($attr, $val, $sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->setAttribute($attr, $val);
    }

    public static function setFetch($mode, $sql, $params = []) {
        $result = self::query($sql, $params);
        return $result->setFetchMode($mode);
    }

    public static function clearTable($table) {
        return self::db()->query("TRUNCATE TABLE $table");
    }

}

if (!class_exists('R')) {
    // Наследуем класс DB
    final class R extends DB{};
}

