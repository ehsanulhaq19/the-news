import apiClient from './client/client'

export const signUpApi = async(payload) => {
    const {email='', first_name='', last_name='', password=''} = payload
    const client = await apiClient()
    
    // return client.register(null, { 
    //         email,
    //         first_name,
    //         last_name,
    //         password
    //     });

    return client.post('/register', { 
        email,
        first_name,
        last_name,
        password
    })
}

export const loginApi = async(payload) => {
    const {email='', password=''} = payload
    const client = await apiClient()
    
    // return client.login(null, { 
    //         email,
    //         password
    //     });
    return client.post('/login', { 
        email,
        password
    })
}
  