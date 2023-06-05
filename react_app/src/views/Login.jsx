import { useRef, useState } from "react";
import { Link } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import axiosClient from "../axios-client";

export default function Login() {

    const emailRef = useRef();
    const passwordRef = useRef();
    const [errors, setErrors] = useState(null);
    const { setUser, setToken } = useStateContext();

    const onSubmit = (ev) => {
        ev.preventDefault();
        const payload = {
            email: emailRef.current.value,
            password: passwordRef.current.value,
        }
        console.log(payload);
        setErrors(null);
        axiosClient.post('/login', payload)
            .then(({ data }) => {
                setUser(data.user);
                setToken(data.token);
            })
            .catch(err => {
                const response = err.response;
                if (response && response.status === 422) {
                    console.log(response.data.errors);
                    if (response.data.errors) {
                        setErrors(response.data.errors);
                    } else {
                        setErrors({
                            email: [response.data.message]
                        });
                    }
                }
            })
    }
    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form onSubmit={onSubmit} action="#">
                    <h1 className="title">
                        Login your account
                    </h1>
                    {errors && <div className="alert">
                        {
                            Object.keys(errors).map(key => (
                                <p> {errors[key][0]} </p>
                            ))}
                    </div>
                    }
                    <input ref={emailRef} type="email" placeholder="Email" />
                    <input ref={passwordRef} type="password" placeholder="Password" />
                    <button className="btn btn-block">Login</button>
                    <p className="message">
                        Not yet member? <Link to="/signup">Register Now</Link>
                    </p>
                </form>
            </div>
        </div>
    )
}