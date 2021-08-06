import * as React from 'react';
import ReactHabitat from 'react-habitat';
import MainPage from './main-page';

const containers = [
    {
        id: "MainPage",
        component: MainPage
    }
];

class MyApp extends ReactHabitat.Bootstrapper {
    constructor() {
        super();
        const builder = new ReactHabitat.ContainerBuilder();
        for (let container of containers) {
            builder.register(container.component).as(container.id);
        }
        this.setContainer(builder.build());
    }
}

export default new MyApp();

