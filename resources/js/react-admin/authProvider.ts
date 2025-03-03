// in resources/js/react_admin/authProvider.js

import { dataProvider } from "./dataProvider";

export const authProvider = {
    login: ({ email, password, rememberChecked = false }) => {
        return dataProvider.postLogin( email, password, rememberChecked )
        .then(response => {
            localStorage.setItem('authenticated', true);
            if (response.status < 200 || response.status >= 300) {
              throw new Error(response.statusText);
            }
        })
        .catch((e) => {
                throw new Error(e.message)
        });
    },
    logout: () => {
        return dataProvider.postLogout()
        .then(response => {
            localStorage.removeItem('authenticated');
            if (response.status < 200 || response.status >= 300) {
              throw new Error(response.statusText);
            }
        })
        .catch((e) => {
            if (e.status != 401) {
                throw new Error(e.message)
            }
        });
    },
    checkAuth: () =>{
        return dataProvider.getIdentity()
            .then(( data ) => {
                return data.json
            })
            .catch(() => {
                throw new Error('Unatuhenticated')
            });
    },
    checkError: (error) => {
        const status = error.status;
        if (status === 401 || status === 403) {
            // return Promise.reject(); // redirect to login page
            return Promise.resolve();
        }
        return Promise.resolve();
    },
    getIdentity: () => {
        return dataProvider.getIdentity()
            .then(( data ) => {
                data.json.avatar = '/storage/' + data.json.avatar
                return data.json
            })
            .catch(() => {
                throw new Error('Unatuhenticated')
            });
    },
    getPermissions: () => {
        return dataProvider.getPermissions()
            .then(( permissions ) => {
                return permissions.json
            })
            .catch((error) => {
                throw new Error(error.message)
            });
    }
};
