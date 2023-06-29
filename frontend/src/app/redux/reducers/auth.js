import { createSlice } from '@reduxjs/toolkit'

export const authSlice = createSlice({
  name: 'auth',
  initialState: {
    token: null,
    user: {}
  },
  reducers: {
    setUser: (state, action) => {
        state.user = action?.payload
    },
    setToken: (state, action) => {
        state.token = action?.payload
        localStorage.setItem('token', action?.payload)
    },
    logout: (state, action) => {
      state.token = null
      state.user = {}

      localStorage.removeItem('token')
    }
  },
})

export const { setUser, setToken, logout } = authSlice.actions

export default authSlice.reducer