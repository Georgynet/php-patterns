<?php

abstract class Duck {
    protected $flyBehavior;
    protected $quackBehavior;

    public function Duck() {}

    abstract public function display();

    public function preformFly() {
        $this->flyBehavior->fly();
    }

    public function preformQuack() {
        $this->quackBehavior->quackle();
    }

    public function setFlyBehavior(FlyBehavior $fb) {
        $this->flyBehavior = $fb;
    }

    public function setQuackBehavior(QuackBehavior $qb) {
        $this->quackBehavior = $qb;
    }

    public function swim() {
        print('All ducks float, even decoys! <br/>');
    }
}

class MallardDuck extends Duck {
    public function MallardDuck() {
        $this->quackBehavior = new Quack();
        $this->flyBehavior = new FlyWithWings();
    }

    public function display() {
        print("I'm a real Mallard duck. <br/>");
    }
}

class ModelDuck extends Duck {
    public function  ModelDuck() {
        $this->flyBehavior = new FlyNoWay();
        $this->quackBehavior = new Quack();
    }

    public function display() {
        print("I'm a model duck. <br/>");
    }
}

class Decoy {
    private $quackBehavior;

    public function  Decoy() {
        $this->quackBehavior = new Quack();
    }

    public function quackle() {
        $this->quackBehavior->quackle();
    }
}

interface FlyBehavior {
    public function fly();
}

class FlyWithWings implements FlyBehavior {
    public function fly() {
        print("I'm flying!!! <br/>");
    }
}

class FlyNoWay implements FlyBehavior {
    public function fly() {
        print("I can't fly. <br/>");
    }
}

class FlyRocketPowered implements  FlyBehavior {
    public function fly() {
        print("I'm flying with a rocket!!! <br/>");
    }
}

interface QuackBehavior {
    public function quackle();
}

class Quack implements QuackBehavior {
    public function quackle() {
        print('Quack <br/>');
    }
}

class MuteQuack implements QuackBehavior {
    public function quackle() {
        print('<< Silence >> <br/>');
    }
}

class Squek implements QuackBehavior {
    public function quackle() {
        print('Squeak <br/>');
    }
}

/*  run  */
$mallard = new MallardDuck();
$mallard->preformQuack();
$mallard->preformFly();

$model = new ModelDuck();
$model->preformFly();
$model->setFlyBehavior(new FlyRocketPowered());
$model->preformFly();

$decoy = new Decoy();
$decoy->quackle();