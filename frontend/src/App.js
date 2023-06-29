import React from 'react';
import { Provider } from 'react-redux'
import { PersistGate } from 'redux-persist/integration/react';
import { persistor, store } from './app/redux/store'
import Routes from './app/routes/AppRoutes';
import 'bootstrap/dist/css/bootstrap.css';
import "./assets/sass/app.scss"

const App = () => {
    return (
        <Provider store={store}>
            <PersistGate loading={null} persistor={persistor}>
                <Routes />
            </PersistGate>
        </Provider>
    );
}

export default App;