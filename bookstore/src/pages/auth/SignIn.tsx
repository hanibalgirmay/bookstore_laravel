import axios from "axios";
import React, { useState } from "react";
import { FormProvider, useForm } from "react-hook-form";
import { Link, useNavigate } from "react-router-dom";
import { CInput, CProvider } from "../../component/form";
import toast from "react-hot-toast";

const SignIn = () => {
  const [loading, setloading] = useState(false);
  const router = useNavigate();
  const methods = useForm();

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  const handleLogin = async (data: any) => {
    // Handle login logic
    await axios
      .post(import.meta.env.VITE_APP_API_URL + "/api/login", data)
      .then((res) => {
        if (res.status === 200) {
          // Get the Set-Cookie header
          const setCookieHeader = res.headers["Set-Cookie"];
          // Extract the cookie value from the header
          console.log("login: ", setCookieHeader);
          const cookieValue = '';
          // const cookieValue = setCookieHeader[0].split(";")[0];

          // Store the cookie in the browser
          document.cookie = cookieValue;

          console.log("====================================");
          console.log("token: ",res.data);
          console.log("====================================");
          localStorage.setItem("token", res?.data?.token);
          // const cookies = res?.headers.get("Set-Cookie");
          if (cookieValue !== null) {
            toast.success("Login successfully");
            router("/");
          }
        }
      })
      .catch((err) => {
        console.error("err", err);
        if (typeof err?.response?.data?.message === "string") {
          toast.error(err?.response?.data?.message);
        } else {
          if (err?.response?.data?.message?.length > 0) {
            err?.response?.data?.message?.forEach((er: any) => {
              toast.error(er);
            });
          } else {
            toast.error(err?.response?.data?.message);
          }
        }
      });
  };
  return (
    <div className="w-full min-w-[350px] max-w-sm p-6 m-auto mx-auto bg-white rounded-lg shadow-md">
      <div className="flex justify-center mx-auto">
        <img
          className="w-auto h-7 sm:h-8"
          src="../../assets/react.svg"
          alt=""
        />
      </div>

      <FormProvider {...methods}>
        <CProvider handleFormSubmit={methods.handleSubmit(handleLogin)}>
          <>
            <h3 className="font-bold text-2xl my-8">Welcome to Bookstore</h3>

            <CInput label="Email" name="email" placeholder="Enter your email" />
            <CInput
              label="Password"
              name="password"
              type="password"
              placeholder="Enter your password"
            />

            <div className="mt-6">
              <button
                type="submit"
                disabled={
                  methods.formState.isSubmitting || !methods.formState.isValid
                }
                className="disabled:cursor-not-allowed disabled:opacity-50 disabled:pointer-events-none w-full px-6 py-3.5 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50"
              >
                {!methods.formState.isSubmitting ? (
                  "Sign In"
                ) : (
                  <div class="text-center">
                    <div role="status">
                      <svg
                        aria-hidden="true"
                        class="inline w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                        viewBox="0 0 100 101"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                          fill="currentColor"
                        />
                        <path
                          d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                          fill="currentFill"
                        />
                      </svg>
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>
                )}
              </button>
            </div>
          </>
        </CProvider>
      </FormProvider>

      <div className="flex items-center justify-between mt-4">
        <span className="w-1/5 border-b dark:border-gray-600 lg:w-1/5"></span>

        <a
          href="#"
          className="text-xs text-center text-gray-500 uppercase dark:text-gray-400 hover:underline"
        ></a>

        <span className="w-1/5 border-b dark:border-gray-400 lg:w-1/5"></span>
      </div>

      <p className="mt-8 text-xs font-light text-center text-gray-400">
        {" "}
        Don't have an account?{" "}
        <Link
          to={"/auth/signup"}
          className="font-medium text-gray-700 hover:underline"
        >
          Create One
        </Link>
      </p>
    </div>
  );
};

export default SignIn;
