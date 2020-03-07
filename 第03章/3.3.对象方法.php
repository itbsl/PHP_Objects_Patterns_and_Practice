<?php
//**************************************************************
/*
 * 本章涵盖的主题
 * 1.类和对象: 声明类和初始化对象
 * 2.构造方法: 自动构造的对象
 * 3.基本类型和类类型: 为什么类型很重要?
 * 4.继承: 为什么需要继承,如何使用继承?
 * 5.可见性: 梳理对象接口,保护方法和属性免受干扰
 */
//**************************************************************

//3.2使用方法

//就像属性允许对象存储数据一样,方法也允许对象执行任务.方法是在类中定义的特殊函数.
//方法的声明与函数的声明类似: 在function关键字后面写上方法名,然后是一对大括号
//大括号内的参数列表是可选的,方法体用大括号括起来.整个方法声明看起来就像下面这样:
/*
public function myMethod($argument, $another)
{
    //...
}
*/
//与函数不同的是,方法必须被声明在类体内.我们也可以给它们加上一些限定词,包括可见性关键字.
//也就是说,与属性一样,方法也可以被声明为public、protected 或 private.将一个方法声明为
//public可以确保从当前对象外部也能够调用该方法.如果在方法声明中省略了可见性关键字,那么该方
//法会被隐式地声明为public.不过,为所有方法都显式地设置可见性是一种优秀的实践.

//示例:
/*
class ShopProduct
{
    public $title = "default product";
    public $producerMainName = "main name";
    public $producerFirstName = "first name";
    public $price = 0;

    public function getProducer()
    {
        return $this->producerFirstName . ' ' . $this->producerMainName;
    }
}

$product = new ShopProduct();
$product->title = "My Antonia";
$product->producerMainName = "Cather";
$product->producerFirstName = "willa";
$product->price = 5.99;

echo "author: {$product->getProducer()}";
*/
//上面这个类的方法体中使用了"伪变量"特性. $this伪变量是一种让类引用自己的对象实例的方式
//如果你觉得这个概念难以理解,那么请试着用"当前实例"这个短语替换$this,即把语句:
//$this->producerFirstName理解为: 当前实例的$producerFirstName属性
//这么做只是稍微改善了一下这个类,其中仍然有一些不受欢迎的不确定性.这个类依赖客户端来设置
//对象的属性值,这种方式有两个问题: 首先,初始化一个ShopProduct对象需要五行代码,所有人
//都会觉得非常麻烦;其次,ShopProduct对象被初始化时,无法保证所有属性都被设置了值.我们
//需要一个在实例化类的对象时会被自动调用的方法.


//**构造方法**
//构造方法会在对象呗创建时被调用.我们可以使用它进行初始化工作,确保所有必要的属性都被设置了值,所有必须
//的准备工作都已完成.
/*
 * 注意:
 * 在PHP5之前,构造方法的名字与类名相同,也就是说ShopProduct类的构造方法就是ShopProduct().
 * 现在这条约定不再适用于所有情况,而且已经被PHP7废除了.在PHP7中,构造方法的名称是__construct().
 * 请注意方法名的开头有两条下划线,我们还会在PHP类的其它特殊方法中看到这种命名约定.
 */

class ShopProduct
{
    public $title = "default product";
    public $producerMainName = "main name";
    public $producerFirstName = "first name";
    public $price = 0;

    public function __construct($title, $firstName, $mainName, $price)
    {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }

    public function getProducer()
    {
        return $this->producerFirstName . ' ' . $this->producerMainName;
    }
}

$product = new ShopProduct("My Antonia", "Willa", "Cather", 5.99);

echo "author: {$product->getProducer()}";

/*
 * 注意:
 * 现在,ShopProduct对象更易于实例化,使用起来也更安全,实例化和初始化只需要一句话即可.
 * 而且可以确信,任何使用ShopProduct对象的代码中的属性都已经被初始化了.
 */

//这种可预测性是面向对象编程中的一个重要方向.我们所设计的类应当能够让对象的调用者知道它有哪些特性.
//一种能确保安全使用类的方法是,确保类中属性的数据类型是可预测的,例如确保$title属性的值都是由字符
//数据组成的.但如果这个数据可能会被传递到类外部,该如何确保这一点呢?
//提示: 在方法声明中强制确定对象类型的方式

//**析构方法**
//1.当一个对象没有被任何变量引用时就会自动销毁,并在被销毁前自动调用析构函数，无论程序有没有结束，
//只要一个对象没有被任何变量引用就会被销毁
//2.当PHP程序运行结束后，所有的对象都会被销毁，对象在被销毁前，会自动调用析构函数。
//3.默认情况下，析构函数销毁对象的顺序和创建对象的顺序正好相反。最先创建的对象最后被销毁，
//强调默认情况下是因为，我们可以手动销毁对象，这样的话对象销毁的顺序就和默认情况不一样了，
//当PHP程序执行完后，那时候销毁对象的方法就是采用的默认方法。
//4.如果我们定义的一个类里专门有个属性是用来连接数据库的，当我们创建了该类的实例对象，
//并且用该成员属性连接数据库后，如果该类型的实例对象占用资源较大，我们往往会在使用后就立即销毁，
//虽然该对象能被销毁，但是该对象的成员属性所连接的资源却不会被自动销毁，需要我们自己手动销毁，
//这时，我们可以在析构函数里添加一句关闭数据库连接的语句就好了（mysql_close(要关闭的资源)）。

//示例:

class Test
{
    public function __construct()
    {
        echo '__construct';
    }

    public function sayHello()
    {
        echo 'hello';
    }

    public function __destruct()
    {
        echo '__destruct';
    }
}

$test = new Test();
$test->sayHello();