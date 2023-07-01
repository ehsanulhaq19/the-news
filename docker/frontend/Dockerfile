# Base image
FROM node:16 as build

# Set working directory
WORKDIR ./

# Copy package.json and yarn.lock to the container
COPY ./frontend/package.json ./
COPY ./frontend/yarn.lock ./

# Install dependencies
RUN yarn install

# Copy all files to the container
COPY ./frontend ./

# Build the React application
RUN yarn build

# Production image
FROM nginx:alpine

# Remove default Nginx configuration
RUN rm /etc/nginx/conf.d/default.conf

# Copy custom Nginx configuration
COPY ./docker/frontend/nginx.conf /etc/nginx/conf.d

# Copy the built React app to Nginx's default public directory
COPY --from=build ./build ./usr/share/nginx/html

# Expose port 3000 for the frontend
EXPOSE 3000

# # Start Nginx when the container runs
CMD ["nginx", "-g", "daemon off;"]